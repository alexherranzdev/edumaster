<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Application\Find;

use Edumaster\Learning\Worksheet\Domain\Worksheet;
use Edumaster\Learning\Worksheet\Domain\WorksheetRepository;
use Edumaster\Learning\Worksheet\Domain\ValueObject\WorksheetId;

class FindWorksheetService
{
  private WorksheetRepository $repository;

  public function __construct(WorksheetRepository $repository)
  {
    $this->repository = $repository;
  }

  public function execute(string $id): ?Worksheet
  {
    return $this->repository->findById(new WorksheetId($id));
  }
}
