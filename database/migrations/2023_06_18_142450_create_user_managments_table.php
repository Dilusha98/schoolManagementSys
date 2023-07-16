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
        Schema::create('user_managments', function (Blueprint $table) {
            $table->id();
            $table->integer('role');
            $table->string('userFirstName');
            $table->string('userLastName');
            $table->string('userEmail');
            $table->string('userAddress');
            $table->string('userTelephone');
            $table->string('UserUserName');
            $table->date('userDOB');
            $table->string('userGender');
            $table->string('userPassword');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_managments');
    }
};
