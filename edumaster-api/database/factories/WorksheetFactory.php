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
        return [
            'worksheet_id' => WorksheetId::generate(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(8),
            'teacher_id' => DB::table('users')->where('email', 'teacher@edumaster.dev')->value('user_id'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
