<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Infrastructure\Persistence;

use Edumaster\Learning\User\Domain\User;
use Illuminate\Database\Eloquent\Model;

class EloquentWorksheetResponse extends Model
{
  protected $table = 'worksheet_responses';
  protected $fillable = ['response_id', 'worksheet_id', 'student_id', 'question_id', 'selected_word', 'is_correct'];

  protected $casts = [
    'is_correct' => 'boolean',
  ];

  public function student()
  {
    return $this->belongsTo(User::class, 'student_id', 'user_id');
  }

  public function question()
  {
    return $this->belongsTo(EloquentWorksheetQuestion::class, 'question_id', 'question_id');
  }
}
