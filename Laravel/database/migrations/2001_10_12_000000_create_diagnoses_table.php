<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Doctors', function (Blueprint $table) {
            $table->id();
            $table->string('firstName', 255);
            $table->string('lastName', 255);
            $table->timestamps();
        });


        Schema::create('Patients', function (Blueprint $table) {
            $table->id();
            $table->string('firstName', 255);
            $table->string('lastName', 255);
            $table->timestamps();
        });

        Schema::create('Diagnoses', function (Blueprint $table) {
            $table->id();
            $table->string('diagnosesName');
            $table->foreignId('doctorsid_id')->constrained("Doctors");
            $table->foreignId('patient_id')->constrained("Patients");
            $table->timestamps();
        });

        Schema::create('Treatment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('patient_id')->constrained("Patients");
            $table->timestamps();
        });

        Schema::create('Schedule', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('doctor_be_tuday_id')->constrained("Doctors");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Doctors');
        Schema::dropIfExists('Patients');
        Schema::dropIfExists('Diagnoses');
        Schema::dropIfExists('Treatment');
        Schema::dropIfExists('Schedule');
    }
};
