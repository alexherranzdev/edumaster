<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Infrastructure\Persistence;

use Edumaster\Learning\Worksheet\Domain\ValueObject\WorksheetId;
use Edumaster\Learning\Worksheet\Domain\WorksheetResponse;
use Edumaster\Learning\Worksheet\Domain\WorksheetResponseRepository;

class EloquentWorksheetResponseRepository implements WorksheetResponseRepository
{
  public function save(WorksheetResponse $response): void
  {
    $response->save();
  }

  public function deleteByWorksheetId(WorksheetId $worksheetId): void
  {
    EloquentWorksheetResponse::where('worksheet_id', $worksheetId->value())->delete();
  }
}
