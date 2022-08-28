<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function targets()
    {
        return $this->belongsTo(Target::class);
    }    
    public function task_explanations()
    {
        return $this->hasMany(Task_explanation::class);
    }
}
