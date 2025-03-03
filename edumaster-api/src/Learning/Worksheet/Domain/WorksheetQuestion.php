<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Domain;

use Illuminate\Database\Eloquent\Model;

class WorksheetQuestion extends Model
{
  protected $keyType = 'integer';
  public $incrementing = true;

  protected $fillable = ['question_id', 'worksheet_id', 'question', 'words', 'correct_word'];

  protected $casts = [
    'words' => 'array',
  ];

  public function worksheet()
  {
    return $this->belongsTo(Worksheet::class, 'worksheet_id', 'worksheet_id');
  }

  public function updateQuestion(string $question, array $words, string $correctWord): void
  {
    $this->question = $question;
    $this->words = $words;
    $this->correct_word = $correctWord;
  }
}
