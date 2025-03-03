<?php

declare(strict_types=1);

namespace Edumaster\Learning\User\Application\Update;

use Edumaster\Learning\User\Domain\Exception\UserNotFoundException;
use Edumaster\Learning\User\Domain\UserRepository;
use Edumaster\Shared\ValueObject\Email;
use Illuminate\Support\Facades\Hash;

class UpdateUserService
{
  public function __construct(private UserRepository $repository) {}

  public function execute(string $id, array $data): void
  {
    $user = $this->repository->findById($id);
    if (!$user) {
      throw new UserNotFoundException($id);
    }

    $user->name = $data['name'];
    $user->email = (new Email($data['email']))->value();

    if (isset($data['password'])) {
      $user->password = Hash::make($data['password']);
    }

    $this->repository->save($user);
  }
}
