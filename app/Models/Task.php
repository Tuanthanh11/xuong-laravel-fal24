<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'status', 'project_id'];

    // Nhiệm vụ thuộc về một dự án
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
