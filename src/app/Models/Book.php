<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        // static::deleting(function ($book) {
        //     $book->book_explanations()->delete();
        // });

        static::deleting(function($book) {
            foreach ($book->book_explanations()->get() as $book_explanation) {
                $book_explanation->delete();
            }
        });
    }

    public function targets()
    {
        return $this->belongsTo(Target::class);
    }    
    public function book_explanations()
    {
        return $this->hasMany(BookExplanation::class);
    }
    public function public_categories()
    {
        return $this->hasOne(PublicCategory::class);
    }
}
