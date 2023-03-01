<?php

namespace App\Models;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    protected $guarded = [];
    use HasFactory;
    public function blog()
    {
        return $this->belongsToMany(Blog::class);
    }
}
