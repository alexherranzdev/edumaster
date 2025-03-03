<?php

namespace Tests\Feature;

use Edumaster\Learning\User\Domain\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorksheetTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_can_create_worksheet()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);

        $this->actingAs($teacher)
            ->postJson('/api/worksheets', [
                'title' => 'Ficha de prueba',
                'description' => 'Descripción de prueba',
                'questions' => [
                    [
                        'question' => '¿Qué es Laravel?',
                        'words' => ['Framework PHP', 'Base de datos', 'Lenguaje'],
                        'correct_word' => 'Framework PHP'
                    ]
                ]
            ])
            ->assertStatus(201)
            ->assertJsonStructure([
                'worksheet_id',
                'title',
                'description',
                'questions'
            ]);

        $this->assertDatabaseHas('worksheets', ['title' => 'Ficha de prueba']);
    }
}
