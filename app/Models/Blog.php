<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;
     // Replace with the actual table name if it's different.
     protected $primaryKey = 'blog_id';
    protected $fillable = ['blog_title', 'blog_content'];
     // Add more columns if needed.
}
