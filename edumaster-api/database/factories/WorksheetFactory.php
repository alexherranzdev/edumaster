<?php

namespace Database\Factories;

use Edumaster\Learning\Worksheet\Domain\ValueObject\WorksheetId;
use Edumaster\Learning\Worksheet\Infrastructure\Persistence\EloquentWorksheet;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Worksheet>
 */
class WorksheetFactory extends Factory
{
    protected $model = EloquentWorksheet::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $words = $this->faker->words(5);
        $correctWord = $words[array_rand($words)];

        return [
            'worksheet_id' => (new WorksheetId())->value(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(8),
            'words' => $words,
            'correct_word' => $correctWord,
            'teacher_id' => DB::table('users')->where('email', 'teacher@edumaster.dev')->value('user_id'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
