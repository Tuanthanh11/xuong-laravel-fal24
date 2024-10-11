<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Classroom;
use App\Models\Comment;
use App\Models\Passport;
use App\Models\Phone;
use App\Models\Post;
use App\Models\Role;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;
use Mockery\Generator\StringManipulation\Pass\Pass;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        


        for ($i = 1; $i < 11; $i++) {
            Subject::create([
                'name' => fake()->text(10),
                'credits' => fake()->numberBetween(1, 10),
            ]);
        }

        // for ($i = 0; $i < 10; $i++) {
        //     Classroom::create([
        //         'name' => fake()->name(),
        //         'teacher_name' => fake()->name(),
        //     ]);
        // }

        // for ($i = 1; $i < 11; $i++) {
        //     Student::create([
        //         'classroom_id' => $i,
        //         'name' => fake()->text,
        //         'email' => fake()->email
        //     ]);
        //     Student::create([
        //         'classroom_id' => $i,
        //         'name' => fake()->text,
        //         'email' => fake()->email
        //     ]);
        //     Student::create([
        //         'classroom_id' => $i,
        //         'name' => fake()->text,
        //         'email' => fake()->email
        //     ]);
        // }
        // $users = User::pluck('id')->all();

        // foreach ($users as $userID) {
        //     Phone::query()->create([
        //         'user_id' => $userID,
        //         'value' => fake()->unique()->phoneNumber(),

        //     ]);
        // }
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
