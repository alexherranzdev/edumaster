<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Model;

class EloquentWorksheetStudent extends Model
{
  protected $table = 'worksheet_students';
  protected $fillable = ['worksheet_id', 'student_id', 'status'];

  protected $casts = [
    'status' => 'string'
  ];
}
