<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Blog; // Replace 'Blog' with the actual model representing your 'blogs' table.
use Illuminate\Support\Facades\Log;

class BlogImport implements ToModel
{
    public function model(array $row)
{
    try {
        return new Blog([
            'blog_title' => $row['blog_title'],
            'blog_content' => $row['blog_content'],
        ]);
    } catch (\Exception $e) {
        Log::error('Error importing row: ' . print_r($row, true));
        Log::error('Error message: ' . $e->getMessage());
        return null; // Return null for the failed row to continue the import process.
    }
}

}
