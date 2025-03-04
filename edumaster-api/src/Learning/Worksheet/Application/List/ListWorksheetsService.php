<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Application\List;

use Edumaster\Learning\User\Domain\ValueObject\UserId;
use Edumaster\Learning\Worksheet\Domain\WorksheetRepository;

class ListWorksheetsService
{
  public function __construct(private WorksheetRepository $repository) {}

  public function execute(
    string $userId,
    string $role,
    int $limit = 100,
    int $offset = 0,
    array $with = [],
    array $filters = []
  ): array {
    if ($role === 'teacher') {
      return $this->repository->findAll(new UserId($userId), $limit, $offset, $with, $filters);
    }

    return $this->repository->findAllByStudent(new UserId($userId), $limit, $offset, $with, $filters);
  }
}
