<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Application\Delete;

use Edumaster\Learning\Worksheet\Domain\Exception\WorksheetNotFoundException;
use Edumaster\Learning\Worksheet\Domain\WorksheetRepository;
use Edumaster\Learning\Worksheet\Domain\ValueObject\WorksheetId;

class DeleteWorksheetService
{
  private WorksheetRepository $repository;

  public function __construct(WorksheetRepository $repository)
  {
    $this->repository = $repository;
  }

  public function execute(string $id): void
  {
    $worksheetId = new WorksheetId($id);
    $this->repository->delete($worksheetId);
  }
}
