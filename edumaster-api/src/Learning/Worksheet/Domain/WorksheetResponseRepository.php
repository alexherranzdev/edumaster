<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Domain;

use Edumaster\Learning\Worksheet\Domain\ValueObject\WorksheetId;

interface WorksheetResponseRepository
{
  public function save(WorksheetResponse $response): void;

  public function deleteByWorksheetId(WorksheetId $worksheetId): void;
}
