<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use Faker\Factory as Faker;

class BookSeeder extends Seeder
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
                'class' => '9',
                'subjects' => [
                    'Mathematics',
                    'Science',
                    'English',
                    'Social Studies',
                    'Computer Science',
                    'Physical Education',
                ],
                'available' => 25,
            ],
            [
                'class' => '10',
                'subjects' => [
                    'Mathematics',
                    'Science',
                    'English',
                    'Social Studies',
                    'Computer Science',
                    'Physical Education',
                ],
                'available' => 25,
            ],
            [
                'class' => '11',
                'subjects' => [
                    'Physics',
                    'Chemistry',
                    'Biology',
                    'Mathematics',
                    'English',
                    'Computer Science',
                ],
                'available' => 25,
            ],
            [
                'class' => '12',
                'subjects' => [
                    'Physics',
                    'Chemistry',
                    'Biology',
                    'Mathematics',
                    'English',
                    'Computer Science',
                ],
                'available' => 25,
            ],
        ];

        // Insert the library data into the database
        foreach ($classSubjects as $classSubject) {
            $class = $classSubject['class'];
            $subjects = $classSubject['subjects'];
            $available = $classSubject['available'];

            foreach ($subjects as $subject) {
                Book::create([
                    'subject' => $subject,
                    'class' => $class,
                    'available' => $available,
                ]);
            }
        }
    }
}
