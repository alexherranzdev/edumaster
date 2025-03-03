<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Domain;

use Edumaster\Learning\User\Domain\ValueObject\UserId;
use Edumaster\Learning\Worksheet\Domain\ValueObject\WorksheetId;

interface WorksheetRepository
{
  public function findById(WorksheetId $id): ?Worksheet;
  public function findAll(UserId $userId, int $limit = 100, int $offset = 0, array $with = []): array;
  public function findAllByTeacher(UserId $teacherId, int $limit = 100, int $offset = 0): array;
  public function findAllByStudent(UserId $studentId, int $limit = 100, int $offset = 0, array $with = []): array;
  public function save(Worksheet $worksheet): void;
  public function delete(WorksheetId $id): void;
}
