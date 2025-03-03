<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Infrastructure\Persistence;

use Edumaster\Learning\Worksheet\Domain\WorksheetStudent;
use Edumaster\Learning\Worksheet\Domain\WorksheetStudentRepository;

class EloquentWorksheetStudentRepository implements WorksheetStudentRepository
{
  public function save(WorksheetStudent $worksheetStudent): void
  {
    EloquentWorksheetStudent::updateOrCreate(
      ['worksheet_id' => $worksheetStudent->worksheetId()->value(), 'student_id' => $worksheetStudent->studentId()->value()],
      ['status' => $worksheetStudent->status()]
    );
  }
}
