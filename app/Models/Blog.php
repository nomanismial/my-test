<?php

namespace App\Models;

use App\Models\Author;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:Y-m-d\TH:i:s.vP'
    ];


    public function getCreated_AtAttribute($value)
    {
        return $value->format('Y-m-d\TH:i:s.vP');
    }
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
