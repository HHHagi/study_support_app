<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function targets()
    {
        return $this->belongsTo(Target::class);
    }    
    public function book_explanations()
    {
        return $this->hasMany(Book_explanation::class);
    }
}
