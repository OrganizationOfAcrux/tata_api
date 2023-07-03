<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        DB::table('roles')->insert([
            'name' => 'principal',
            'description' => 'jshfjsh',
           ]);

        DB::table('roles')->insert([
         'name' => 'teacher',
         'description' => 'jshfjsh',
        ]);

        DB::table('roles')->insert([
         'name' => 'student',
         'description' => 'jshfjsh',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
