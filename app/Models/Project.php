<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'start_date'];

    // Một dự án có nhiều nhiệm vụ
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
