<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'classroom' => [
                'id' => $this->classroom->id,
                'name' => $this->classroom->name,
                'teacher_name' => $this->classroom->teacher_name,
            ],
            'passport' => [
                'passport_number' => $this->passport->passport_number,
                'issued_date' => $this->passport->issued_date,
                'expiry_date' => $this->passport->expiry_date,
            ],
            'subjects' => $this->subjects->map(function ($subject) {
                return [
                    'id' => $subject->id,
                    'name' => $subject->name,
                    'credits' => $subject->credits,
                ];
            }),
        ];
    }
}
