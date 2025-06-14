<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
      use HasFactory;

    protected $fillable = [
        'project_id', 'title', 'completed', 'due_date'
    ];

    public function projects()
    {
        return $this->belongsTo(Project::class,'project_id');
    }

}
