<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'priority'    => $this->priority,
            'status'      => $this->status,
            'due_date'    => $this->due_date,
            // بيجيب اسم الـ category لو موجودة
            'category'    => $this->category ? [
                'id'    => $this->category->id,
                'name'  => $this->category->name,
                'color' => $this->category->color,
            ] : null,
        ];
    }
}