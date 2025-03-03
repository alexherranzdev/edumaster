<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Application\List;

use Edumaster\Learning\User\Domain\ValueObject\UserId;
use Edumaster\Learning\Worksheet\Domain\WorksheetRepository;

class ListTeacherWorksheetsService
{
  private WorksheetRepository $repository;

  public function __construct(WorksheetRepository $repository)
  {
    $this->repository = $repository;
  }

  public function execute(string $teacherId, int $limit = 100, int $offset = 0): array
  {
    return $this->repository->findAllByTeacher(new UserId($teacherId), $limit, $offset);
  }
}
