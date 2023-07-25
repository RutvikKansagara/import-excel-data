<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BlogController extends Controller
{
    public function importExcel(Request $request)
    {
        try {
            $file = public_path('Book1.xlsx');
            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            foreach ($rows as $row) {
                // Assuming the first column contains blog_title and the second contains blog_content.
                $blogTitle = $row[0];
                $blogContent = $row[1];

                // Save the data to the "blogs" table.
                Blog::create([
                    'blog_title' => $blogTitle,
                    'blog_content' => $blogContent,
                ]);
            }

            return "Data imported successfully.";
        } catch (\Exception $e) {
            return "Error occurred during data import: " . $e->getMessage();
        }
    }
}
