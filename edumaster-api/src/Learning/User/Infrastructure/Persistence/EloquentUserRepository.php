<?php

declare(strict_types=1);

namespace Edumaster\Learning\User\Infrastructure\Persistence;

use Edumaster\Learning\User\Domain\User;
use Edumaster\Learning\User\Domain\UserRepository;

class EloquentUserRepository implements UserRepository
{
  public function findById(string $id): ?User
  {
    return User::where('user_id', $id)->first();
  }

  public function findByEmail(string $email): ?User
  {
    return User::where('email', $email)->first();
  }

  public function findByRole(string $role, int $limit = 100, int $offset = 0): array
  {
    return User::where('role', $role)
      ->limit($limit)
      ->offset($offset)
      ->get()
      ->all();
  }

  public function save(User $user): void
  {
    $user->save();
  }

  public function delete(User $user): void
  {
    $user->delete();
  }
}
