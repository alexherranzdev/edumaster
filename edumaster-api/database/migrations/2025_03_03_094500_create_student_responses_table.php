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
        Schema::create('worksheet_responses', function (Blueprint $table) {
            $table->id();
            $table->uuid('response_id')->unique();
            $table->uuid('worksheet_id');
            $table->uuid('question_id');
            $table->uuid('student_id');
            $table->string('selected_word');
            $table->boolean('is_correct');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worksheet_responses');
    }
};
