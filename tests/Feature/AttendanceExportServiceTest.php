<?php

namespace Tests\Feature;

use App\Services\AttendanceExportService;
use Illuminate\Support\Collection;
use Tests\TestCase;
use ZipArchive;

class AttendanceExportServiceTest extends TestCase
{
    public function test_it_creates_a_styled_excel_workbook(): void
    {
        $response = app(AttendanceExportService::class)->download(new Collection);
        $path = $response->getFile()->getPathname();
        $archive = new ZipArchive;

        try {
            $this->assertTrue($archive->open($path) === true);
            $this->assertNotFalse($archive->locateName('xl/styles.xml'));
            $worksheet = $archive->getFromName('xl/worksheets/sheet1.xml');
            $this->assertStringContainsString('state="frozen"', $worksheet);
            $this->assertStringContainsString('autoFilter', $worksheet);
        } finally {
            $archive->close();
            @unlink($path);
        }
    }
}
