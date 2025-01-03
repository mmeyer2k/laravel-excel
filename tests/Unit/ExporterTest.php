<?php

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class ExporterTest extends TestCase
{
    const FILE = __DIR__.'/../docs/test.xlsx';

    public function setUp() : void
    {
        parent::setUp();
        $this->file = __DIR__.'/../docs/test.xlsx';
        (new Migration)->up();
    }

    public function tearDown() : void
    {
        (new Migration)->down();
        parent::tearDown();
    }

    public function test_can_export_csv()
    {
        $itemsToSeed = 2;
        $this->seed($itemsToSeed);

        //Export the file
        $exporter = $this->app->make('cyber-duck/exporter')->make('Csv');
        $exporter->load(Item::all())->save(self::FILE);

        //Read the content
        $lines = 0;
        $reader = ReaderEntityFactory::createCSVReader();
        $reader->open($this->file);
        foreach ($reader->getSheetIterator() as $index => $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $this->assertEquals(array_values($this->defaultRow), $row->toArray());
                $lines++;
            }
        }
        $reader->close();
        $this->assertEquals($itemsToSeed, $lines);

        unlink(self::FILE);
    }

    public function test_can_export_ods()
    {
        $itemsToSeed = 2;
        $this->seed($itemsToSeed);

        //Export the file
        $exporter = $this->app->make('cyber-duck/exporter')->make('OpenOffice');
        $exporter->load(Item::all())->save(self::FILE);

        //Read the content
        $lines = 0;
        $reader = ReaderEntityFactory::createODSReader();
        $reader->open($this->file);
        foreach ($reader->getSheetIterator() as $index => $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $this->assertEquals(array_values($this->defaultRow), $row->toArray());
                $lines++;
            }
        }
        $reader->close();
        $this->assertEquals($itemsToSeed, $lines);

        unlink(self::FILE);
    }

    public function test_can_export_xlsx()
    {
        $itemsToSeed = 2;
        $this->seed($itemsToSeed);

        //Export the file
        $exporter = $this->app->make('cyber-duck/exporter')->make('Excel');
        $exporter->load(Item::all())->save(self::FILE);

        //Read the content
        $lines = 0;
        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open($this->file);
        foreach ($reader->getSheetIterator() as $index => $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $this->assertEquals(array_values($this->defaultRow), $row->toArray());
                $lines++;
            }
        }
        $reader->close();
        $this->assertEquals($itemsToSeed, $lines);

        unlink(self::FILE);
    }

    public function test_can_use_a_query_builder()
    {
        $itemsToSeed = 2;
        $this->seed($itemsToSeed);

        //Export the file
        $exporter = $this->app->make('cyber-duck/exporter')->make('Csv');
        $exporter->loadQuery(Item::getQuery())->save(self::FILE);

        //Read the content
        $lines = 0;
        $reader = ReaderEntityFactory::createCSVReader();
        $reader->open($this->file);
        foreach ($reader->getSheetIterator() as $index => $sheet) {
            foreach ($sheet->getRowIterator() as $idx => $row) {
                $expected = array_merge([strval($idx)], array_values($this->defaultRow));
                $this->assertEquals($expected, $row->toArray());
                $lines++;
            }
        }
        $reader->close();
        $this->assertEquals($itemsToSeed, $lines);

        unlink(self::FILE);
    }

    public function test_can_use_a_query_builder_with_chunk()
    {
        $itemsToSeed = 2;
        $this->seed($itemsToSeed);

        //Export the file
        $exporter = $this->app->make('cyber-duck/exporter')->make('Csv');
        $exporter->loadQuery(Item::getQuery())->setChunk(2)->save(self::FILE);

        //Read the content
        $lines = 0;
        $reader = ReaderEntityFactory::createCSVReader();
        $reader->open($this->file);
        foreach ($reader->getSheetIterator() as $index => $sheet) {
            foreach ($sheet->getRowIterator() as $idx => $row) {
                $expected = array_merge([strval($idx)], array_values($this->defaultRow));
                $this->assertEquals($expected, $row->toArray());
                $lines++;
            }
        }
        $reader->close();
        $this->assertEquals($itemsToSeed, $lines);

        unlink(self::FILE);
    }

    public function test_can_use_a_custom_serialiser()
    {
        $itemsToSeed = 2;
        $this->seed($itemsToSeed);

        //Export the file
        $exporter = $this->app->make('cyber-duck/exporter')->make('Csv');
        $exporter->setSerialiser(new FirstColumnOnlySerialiser())->load(Item::all())->save(self::FILE);

        //Read the content
        $lines = 0;
        $reader = ReaderEntityFactory::createCSVReader();
        $reader->open($this->file);
        foreach ($reader->getSheetIterator() as $index => $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                if ($lines == 0) {
                    $this->assertEquals(['HEADER'], $row->toArray());
                } else {
                    $this->assertEquals(['A'], $row->toArray());
                }
                $lines++;
            }
        }
        $reader->close();

        unlink(self::FILE);
    }
}
