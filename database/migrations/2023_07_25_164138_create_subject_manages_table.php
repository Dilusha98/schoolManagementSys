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
        Schema::create('subject_manages', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->string('description');
            $table->string('01');
            $table->string('02');
            $table->string('03');
            $table->string('04');
            $table->string('05');
            $table->string('06');
            $table->string('07');
            $table->string('08');
            $table->string('09');
            $table->string('10');
            $table->string('11');
            $table->string('12');
            $table->string('13');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_manages');
    }
};
