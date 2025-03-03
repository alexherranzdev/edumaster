<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Model;

class EloquentWorksheetQuestion extends Model
{
  protected $table = 'worksheet_questions';
  protected $fillable = ['question_id', 'worksheet_id', 'question', 'words', 'correct_word'];

  protected $casts = [
    'words' => 'array',
  ];
}
