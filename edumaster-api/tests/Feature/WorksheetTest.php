<?php

namespace Tests\Feature;

use Edumaster\Learning\User\Domain\User;
use Edumaster\Learning\Worksheet\Domain\Worksheet;
use Edumaster\Learning\Worksheet\Infrastructure\Persistence\EloquentWorksheet;
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

    public function test_teacher_cannot_create_worksheet_without_questions()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);

        $this->actingAs($teacher)
            ->postJson('/api/worksheets', [
                'title' => 'Ficha sin preguntas',
                'description' => 'Esto no debería guardarse',
                'questions' => []
            ])
            ->assertStatus(422);

        $this->assertDatabaseMissing('worksheets', ['title' => 'Ficha sin preguntas']);
    }

    public function test_student_cannot_create_worksheet()
    {
        $student = User::factory()->create(['role' => 'student']);

        $this->actingAs($student)
            ->postJson('/api/worksheets', [
                'title' => 'Ficha no permitida',
                'description' => 'Un estudiante no debería poder hacer esto',
                'questions' => [
                    [
                        'question' => '¿Qué es PHP?',
                        'words' => ['Lenguaje', 'Framework', 'Base de datos'],
                        'correct_word' => 'Lenguaje'
                    ]
                ]
            ])
            ->assertStatus(403);

        $this->assertDatabaseMissing('worksheets', ['title' => 'Ficha no permitida']);
    }

    public function test_student_cannot_delete_worksheet(): void
    {
        $student = User::factory()->create(['role' => 'student']);

        $worksheet = EloquentWorksheet::factory()->create([
            'teacher_id' => $student->user_id,
        ]);

        $this->actingAs($student);

        $response = $this->deleteJson("/api/worksheets/{$worksheet->id}");

        $response->assertStatus(403);
    }

    public function test_worksheets_pagination_works(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        EloquentWorksheet::factory(25)->create(['teacher_id' => $teacher->user_id]);

        $this->actingAs($teacher);

        $response = $this->getJson('/api/worksheets?limit=10&offset=0');

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data');
    }
}
