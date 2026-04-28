<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory; // ← ده المهم

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'priority',
        'status',
        'due_date',
        'reminder_sent_at',
    ];
     public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Task belongs to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}