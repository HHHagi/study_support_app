<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateCategory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
}

// 最初privateになってたから注意！