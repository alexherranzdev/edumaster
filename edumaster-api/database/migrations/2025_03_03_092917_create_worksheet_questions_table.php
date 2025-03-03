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
        Schema::create('worksheet_questions', function (Blueprint $table) {
            $table->id();
            $table->uuid('question_id')->unique();
            $table->uuid('worksheet_id');
            $table->string('question');
            $table->json('words');
            $table->string('correct_word');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worksheet_questions');
    }
};
