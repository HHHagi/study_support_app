<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        return $this->hasMany(Like::class, 'target_id');
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


    public function is_liked_by_auth_user()
    {
      $id = Auth::id();
  
      $likers = array();
      foreach($this->likes as $like) {
        array_push($likers, $like->user_id);
      }
  
      if (in_array($id, $likers)) {
        return true;
      } else {
        return false;
      }
    }
}
