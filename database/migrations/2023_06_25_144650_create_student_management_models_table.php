<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_management_models', function (Blueprint $table) {
            $table->id();
            $table->string('studentFullName',250);
            $table->string('studentInitials',25);
            $table->date('studentBirthday');
            $table->string('studentGender');
            $table->string('studentNationality');
            $table->string('guardianType');
            $table->string('guardianFullName',250);
            $table->string('guardianInitials',25);
            $table->string('guardianNIC',15);
            $table->date('guardianBirthday');
            $table->string('guardianEmail');
            $table->string('guardianAddress');
            $table->integer('guardianPostalCode');
            $table->string('guardianOccupation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_management_models');
    }
};
