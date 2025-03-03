<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Domain;

use Edumaster\Learning\Worksheet\Domain\ValueObject\QuestionId;
use Illuminate\Database\Eloquent\Model;

class Worksheet extends Model
{
  protected $keyType = 'integer';
  public $incrementing = true;

  protected $fillable = ['worksheet_id', 'teacher_id', 'title', 'description'];

  public function questions()
  {
    return $this->hasMany(WorksheetQuestion::class, 'worksheet_id', 'worksheet_id');
  }

  public function responses()
  {
    return $this->hasMany(WorksheetResponse::class, 'worksheet_id', 'worksheet_id');
  }

  public function addQuestion(WorksheetQuestion $question): void
  {
    $this->questions[] = $question;
  }
  public function replaceQuestion(WorksheetQuestion $updatedQuestion): void
  {
    foreach ($this->questions as $index => $existingQuestion) {
      if ($existingQuestion->question_id === $updatedQuestion->question_id) {
        $this->questions[$index] = $updatedQuestion;
        return;
      }
    }
  }

  public function removeQuestion(WorksheetQuestion $question): void
  {
    foreach ($this->questions as $index => $existingQuestion) {
      if ($existingQuestion->question_id === $question->question_id) {
        unset($this->questions[$index]);
        return;
      }
    }
  }

  public function findQuestionById(QuestionId $questionId): ?WorksheetQuestion
  {
    foreach ($this->questions as $question) {
      if ($question->question_id === $questionId->value()) {
        return $question;
      }
    }
    return null;
  }
}
