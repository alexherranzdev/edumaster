<?php

declare(strict_types=1);

namespace Edumaster\Learning\User\Application\List;

use Edumaster\Learning\User\Domain\UserRepository;

class ListUsersByRoleService
{
  private UserRepository $repository;

  public function __construct(UserRepository $repository)
  {
    $this->repository = $repository;
  }

  public function execute(string $role, int $limit = 100, int $offset = 0): array
  {
    return $this->repository->findByRole($role, $limit, $offset);
  }
}
