<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory; // ← ده المهم

    protected $fillable = [
        'user_id',
        'name',
        'color',
    ]; 

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