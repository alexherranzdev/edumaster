<?php

declare(strict_types=1);

namespace Edumaster\Learning\User\Application\Delete;

use Edumaster\Learning\User\Domain\Exception\UserNotFoundException;
use Edumaster\Learning\User\Domain\UserRepository;

class DeleteUserService
{
  public function __construct(private UserRepository $repository) {}

  public function execute(string $id): void
  {
    $user = $this->repository->findById($id);
    if (!$user) {
      throw new UserNotFoundException($id);
    }

    $this->repository->delete($user);
  }
}
