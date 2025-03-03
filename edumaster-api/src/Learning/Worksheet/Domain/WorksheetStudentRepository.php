<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Domain;

interface WorksheetStudentRepository
{
  public function save(WorksheetStudent $response): void;
}
