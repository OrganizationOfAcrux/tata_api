<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Library;
use Faker\Factory as Faker;

class LibrarySeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Define the class and subject data
        $classSubjects = [
            [
                'class' => '9th',
                'subjects' => [
                    'Mathematics',
                    'Science',
                    'English',
                    'Social Studies',
                    'Computer Science',
                    'Physical Education',
                ],
                'available' => 20,
            ],
            [
                'class' => '10th',
                'subjects' => [
                    'Mathematics',
                    'Science',
                    'English',
                    'Social Studies',
                    'Computer Science',
                    'Physical Education',
                ],
                'available' => 20,
            ],
            [
                'class' => '11th',
                'subjects' => [
                    'Physics',
                    'Chemistry',
                    'Biology',
                    'Mathematics',
                    'English',
                ],
                'available' => 15,
            ],
            [
                'class' => '12th',
                'subjects' => [
                    'Physics',
                    'Chemistry',
                    'Biology',
                    'Mathematics',
                    'English',
                ],
                'available' => 15,
            ],
        ];

        // Insert the library data into the database
        foreach ($classSubjects as $classSubject) {
            $class = $classSubject['class'];
            $subjects = $classSubject['subjects'];
            $available = $classSubject['available'];

            foreach ($subjects as $subject) {
                Library::create([
                    'subject' => $subject,
                    'class' => $class,
                    'available' => $available,
                ]);
            }
        }
    }
}
