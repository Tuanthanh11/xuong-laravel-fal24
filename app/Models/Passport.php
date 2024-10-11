<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passport extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'passport_number',
        'issued_date',
        'expiry_date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
