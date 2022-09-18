<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        // static::deleting(function ($book) {
        //     $book->book_explanations()->delete();
        // });

        static::deleting(function($task) {
            foreach ($task->task_explanations()->get() as $task_explanation) {
                $task_explanation->delete();
            }
        });
    }

    public function targets()
    {
        return $this->belongsTo(Target::class);
    }    
    public function task_explanations()
    {
        return $this->hasMany(TaskExplanation::class);
    }
    public function public_categories()
    {
        return $this->hasOne(PublicCategory::class);
    }
}
