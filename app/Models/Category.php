<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
#[Fillable([ 'user_id','name','color'])]

class Category extends Model
{
    use HasFactory; // ← ده المهم

 

      public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Category has many Tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}