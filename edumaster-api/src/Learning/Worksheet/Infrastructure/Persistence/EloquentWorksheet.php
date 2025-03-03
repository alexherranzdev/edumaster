<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Infrastructure\Persistence;

use Database\Factories\WorksheetFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentWorksheet extends Model
{
  use HasFactory;

  protected $table = 'worksheets';

  protected $fillable = ['worksheet_id', 'teacher_id', 'title', 'description'];

  protected $casts = [
    'words' => 'array',
  ];

  protected static function newFactory()
  {
    return WorksheetFactory::new();
  }
}
