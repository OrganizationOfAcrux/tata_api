<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username');
            $table->string('email');
            $table->string('phone_number');
            $table->string('password');
            $table->string('reset_token')->nullable();
            $table->timestamps();
        });

        DB::table('users')->insert([
         'first_name' => 'Chiramjeev',
         'last_name' => 'Poriya',
         'username' => 'Poriya@1',
         'email' => 'chiranjeev@poriya.com',
         'phone_number' => '(+91)8445937832',
         'password' => Hash::make('123456'),
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
