<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $roles = Role::pluck('id')->toArray(); // Get all role ids from the roles table

        $userCount = 99;
        $role2Count = 9;
        // $role1Count = 1;
        $role3Count = $userCount - $role2Count;//- $role1Count

        $usersToCreate = [];

        for ($i = 0; $i < $userCount; $i++) {
            $role = 3; // Default role_id is 3

            if ($role2Count > 0 && $i < $role2Count) {
                $role = 2; // Assign role_id 2 to the first 9 users
            }
            // elseif ($role1Count > 0 && $i < ($role2Count + $role1Count)) {
            //     $role = 1; // Assign role_id 1 to the 10th user
            // }

            $user = [
                'first_name' => $faker->name,
                'last_name' => $faker->name,
                'username' => $faker->username,
                'email' => $faker->email,
                'password' => $faker->password,
                'phone_number' => $faker->phoneNumber,
                'role_id' => $role,
            ];

            $usersToCreate[] = $user;
        }

        User::insert($usersToCreate);
    }
}
