<?php

declare(strict_types=1);

namespace Edumaster\Learning\User\Domain;

interface UserRepository
{
  public function findById(string $id): ?User;
  public function findByEmail(string $email): ?User;
  public function findByRole(string $role, int $limit = 100, int $offset = 0): array;
  public function save(User $user): void;
  public function delete(User $user): void;
}
