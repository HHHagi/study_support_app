<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $dates = ['limit'];

    public static function boot()
    {
        parent::boot();

        // static::deleting(function ($target) {
        //     $target->books()->delete();
        //     $target->tasks()->delete();
        // });
// ？？
        static::deleting(function($target) {
            foreach ($target->books()->get() as $book) {
                $book->delete();
            }
        });

        static::deleting(function($target) {
            foreach ($target->tasks()->get() as $task) {
                $task->delete();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function books(){
        return $this->hasMany(Book::class);
    }
    public function tasks(){
        return $this->hasMany(Task::class);
    }
    public function likes(){
        return $this->hasMany(Like::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function public_categories()
    {
        return $this->hasOne(PublicCategory::class);
    }
    public function private_categories()
    {
        return $this->hasOne(PrivateCategory::class);
    }
}
