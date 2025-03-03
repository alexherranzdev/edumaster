<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Domain\Exception;

use Edumaster\Shared\Domain\Exception\DomainException;

class WorksheetNotFoundException extends DomainException
{
  public function __construct(string $worksheetId)
  {
    parent::__construct(
      "Worksheet with ID {$worksheetId} not found",
      "worksheet_not_found",
      404
    );
  }
}
