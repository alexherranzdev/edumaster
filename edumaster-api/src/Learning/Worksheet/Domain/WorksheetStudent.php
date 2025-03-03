<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Domain;

use Edumaster\Learning\User\Domain\ValueObject\UserId;
use Edumaster\Learning\Worksheet\Domain\ValueObject\WorksheetId;
use Edumaster\Learning\Worksheet\Domain\ValueObject\WorksheetStatus;

class WorksheetStudent
{
  public function __construct(
    private WorksheetId $worksheetId,
    private UserId $studentId,
    private WorksheetStatus $status
  ) {}

  public function worksheetId(): WorksheetId
  {
    return $this->worksheetId;
  }

  public function studentId(): UserId
  {
    return $this->studentId;
  }

  public function status(): WorksheetStatus
  {
    return $this->status;
  }
}
