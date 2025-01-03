<?php

use Cyberduck\LaravelExcel\Factory\ImporterFactory;
use Cyberduck\LaravelExcel\Factory\ExporterFactory;

class ImporterFactoryTest extends TestCase
{
    public function test_factory_can_create_csv()
    {
        $factory = new ImporterFactory();
        $spreadsheet = $factory->make('Csv');
        $this->assertInstanceOf(
            \Cyberduck\LaravelExcel\Importer\Csv::class,
            $spreadsheet
        );
        $this->assertEquals(
            \Box\Spout\Common\Type::CSV,
            $spreadsheet->getType()
        );
    }

    public function test_factory_can_create_odt()
    {
        $factory = new ImporterFactory();
        $spreadsheet = $factory->make('OpenOffice');
        $this->assertInstanceOf(
            \Cyberduck\LaravelExcel\Importer\OpenOffice::class,
            $factory->make('OpenOffice')
        );
        $this->assertEquals(
            \Box\Spout\Common\Type::ODS,
            $spreadsheet->getType()
        );
    }

    public function test_factory_can_create_xls()
    {
        $factory = new ImporterFactory();
        $spreadsheet = $factory->make('Excel');
        $this->assertInstanceOf(
            \Cyberduck\LaravelExcel\Importer\Excel::class,
            $factory->make('Excel')
        );
        $this->assertEquals(
            \Box\Spout\Common\Type::XLSX,
            $spreadsheet->getType()
        );
    }
    public function test_exporter_factory_can_create_csv()
    {
        $factory = new ExporterFactory();
        $spreadsheet = $factory->make('Csv');
        $this->assertInstanceOf(
            \Cyberduck\LaravelExcel\Exporter\Csv::class,
            $spreadsheet
        );
        $this->assertEquals(
            \Box\Spout\Common\Type::CSV,
            $spreadsheet->getType()
        );
    }

    public function test_exporter_factory_can_create_odt()
    {
        $factory = new ExporterFactory();
        $spreadsheet = $factory->make('OpenOffice');
        $this->assertInstanceOf(
            \Cyberduck\LaravelExcel\Exporter\OpenOffice::class,
            $spreadsheet
        );
        $this->assertEquals(
            \Box\Spout\Common\Type::ODS,
            $spreadsheet->getType()
        );
    }

    public function test_exporter_factory_can_create_xls()
    {
        $factory = new ExporterFactory();
        $spreadsheet = $factory->make('Excel');
        $this->assertInstanceOf(
            \Cyberduck\LaravelExcel\Exporter\Excel::class,
            $spreadsheet
        );
        $this->assertEquals(
            \Box\Spout\Common\Type::XLSX,
            $spreadsheet->getType()
        );
    }
}
