<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Blog;

class ImportExcelData extends Command
{
    protected $signature = 'import:blogs';

    protected $description = 'Import data from blog_data.xlsx into blogs table';

    public function handle()
    {
        try {
            $file = public_path('Book1.xlsx');
            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            if (empty($rows)) {
                $this->error('No data found in the Excel file.');
                return;
            }

            $headerRow = array_shift($rows);

            if (!isset($headerRow[0]) || $headerRow[0] !== 'blog_title' || !isset($headerRow[1]) || $headerRow[1] !== 'blog_content') {
                $this->error('Invalid column headers in the Excel file. Please use "blog_title" and "blog_content".');
                return;
            }

            $this->info('Importing data...');

            foreach ($rows as $row) {
                if (empty($row[0]) || empty($row[1])) {
                    $this->warn('Skipping row: Empty blog_title or blog_content.');
                    continue;
                }

                $blogTitle = $row[0];
                $blogContent = $row[1];

                // Save the data to the "blogs" table.
                Blog::create([
                    'blog_title' => $blogTitle,
                    'blog_content' => $blogContent,
                ]);
            }

            $this->info('Data import completed successfully.');
        } catch (\Exception $e) {
            $this->error('Error occurred during data import: ' . $e->getMessage());
        }
    }
}
