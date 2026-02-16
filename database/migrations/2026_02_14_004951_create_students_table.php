<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // nag migrate sa database sa rows 
    public function up(): void
    {
        // the Schema is create the students table, 
        Schema::create('students', function (Blueprint $table) {
            $table->uuid();
            $table->string('student_id')->unique();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email')->unique();
            // $table->string('password');
            $table->year('year_level');
            $table->string('course', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
