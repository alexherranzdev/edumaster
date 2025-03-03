<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Domain;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class WorksheetResponse extends Model
{
  protected $table = 'worksheet_responses';

  protected $keyType = 'integer';
  public $incrementing = true;

  protected $fillable = ['response_id', 'worksheet_id', 'question_id', 'student_id', 'selected_word', 'is_correct'];

  public function worksheet()
  {
    return $this->belongsTo(Worksheet::class, 'worksheet_id', 'worksheet_id');
  }

  public function question()
  {
    return $this->belongsTo(WorksheetQuestion::class, 'question_id', 'question_id');
  }

  public function student()
  {
    return $this->belongsTo(User::class, 'student_id', 'user_id');
  }
}
