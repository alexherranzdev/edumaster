<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Infrastructure\Persistence;

use Edumaster\Learning\User\Domain\ValueObject\UserId;
use Edumaster\Learning\Worksheet\Domain\ValueObject\QuestionId;
use Edumaster\Learning\Worksheet\Domain\ValueObject\WorksheetId;
use Edumaster\Learning\Worksheet\Domain\Worksheet;
use Edumaster\Learning\Worksheet\Domain\WorksheetQuestion;
use Edumaster\Learning\Worksheet\Domain\WorksheetRepository;

class EloquentWorksheetRepository implements WorksheetRepository
{
  public function findById(WorksheetId $id): ?Worksheet
  {
    $worksheet = Worksheet::with('questions')->where('worksheet_id', $id->value())->first();

    if (!$worksheet) {
      return null;
    }

    $questions = $worksheet->questions->map(function ($q) {
      $worksheetQuestion = new WorksheetQuestion();
      $worksheetQuestion->question_id = $q->question_id;
      $worksheetQuestion->worksheet_id = $q->worksheet_id;
      $worksheetQuestion->question = $q->question;
      $worksheetQuestion->words = $q->words;
      $worksheetQuestion->correct_word = $q->correct_word;

      return $worksheetQuestion;
    });

    $worksheet->questions = $questions;
    return $worksheet;
  }

  public function findAll(UserId $userId, int $limit = 100, int $offset = 0, array $with = [], array $filters = []): array
  {
    $with = array_merge(['questions'], $with);

    $worksheets = Worksheet::with($with);

    foreach ($filters as $filter) {
      $worksheets->where('title', $filter['operator'], $filter['value']);
    }

    $worksheets = $worksheets->limit($limit + 1)
      ->offset($offset)
      ->get();

    $hasMore = $worksheets->count() > $limit;

    return [
      'data' => $worksheets->take($limit)->all(),
      'hasMore' => $hasMore
    ];
  }

  public function findAllByStudent(UserId $studentId, int $limit = 100, int $offset = 0, array $with = [], array $filters = []): array
  {
    $with = array_merge(['questions'], $with);

    $withRelations = [];
    foreach ($with as $relation) {
      if ($relation === 'responses') {
        $withRelations['responses'] = function ($query) use ($studentId) {
          $query->where('student_id', $studentId->value());
        };
      } else {
        $withRelations[] = $relation;
      }
    }

    $worksheets = Worksheet::with($withRelations);

    foreach ($filters as $filter) {
      $worksheets->where($filter['field'], $filter['operator'], $filter['value']);
    }

    $worksheets = $worksheets->limit($limit + 1)
      ->offset($offset)
      ->get();

    $hasMore = $worksheets->count() > $limit;

    return [
      'data' => $worksheets->take($limit)->all(),
      'hasMore' => $hasMore
    ];
  }

  public function findAllByTeacher(UserId $teacherId, int $limit = 100, int $offset = 0): array
  {
    return Worksheet::where('teacher_id', $teacherId->value())
      ->limit($limit)
      ->offset($offset)
      ->get()
      ->all();
  }

  public function findQuestionById(QuestionId $id): ?WorksheetQuestion
  {
    $eloquentQuestion = EloquentWorksheetQuestion::where('question_id', $id->value())->first();

    if (!$eloquentQuestion) {
      return null;
    }

    return new WorksheetQuestion([
      (new QuestionId($eloquentQuestion->question_id))->value(),
      (new WorksheetId($eloquentQuestion->worksheet_id))->value(),
      $eloquentQuestion->question,
      json_decode($eloquentQuestion->words, true),
      $eloquentQuestion->correct_word
    ]);
  }

  public function save(Worksheet $worksheet): void
  {
    $eloquentWorksheet = EloquentWorksheet::updateOrCreate(
      ['worksheet_id' => $worksheet->worksheet_id],
      [
        'worksheet_id' => $worksheet->worksheet_id,
        'title' => $worksheet->title,
        'description' => $worksheet->description,
        'teacher_id' => $worksheet->teacher_id,
      ]
    );

    $existingQuestionIds = EloquentWorksheetQuestion::where('worksheet_id', $eloquentWorksheet->worksheet_id)
      ->pluck('question_id')
      ->toArray();

    $newQuestionIds = array_map(fn($q) => $q['question_id'], $worksheet->questions->toArray());
    $questionsToDelete = array_diff($existingQuestionIds, $newQuestionIds);

    if (!empty($questionsToDelete)) {
      EloquentWorksheetQuestion::whereIn('question_id', $questionsToDelete)->delete();
    }

    foreach ($worksheet->questions as $question) {
      EloquentWorksheetQuestion::updateOrCreate(
        ['question_id' => $question->question_id],
        [
          'worksheet_id' => $eloquentWorksheet->worksheet_id,
          'question_id' => $question->question_id,
          'question' => $question->question,
          'words' => $question->words,
          'correct_word' => $question->correct_word,
        ]
      );
    }
  }

  public function delete(WorksheetId $id): void
  {
    $worksheet = $this->findById($id);
    $worksheet->delete();
  }
}
