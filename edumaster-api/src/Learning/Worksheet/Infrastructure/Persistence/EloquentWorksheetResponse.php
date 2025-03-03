<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Model;

class EloquentWorksheetResponse extends Model
{
  protected $table = 'worksheet_responses';
  protected $fillable = ['response_id', 'worksheet_id', 'student_id', 'question_id', 'selected_word', 'is_correct'];

  protected $casts = [
    'is_correct' => 'boolean',
  ];
}
