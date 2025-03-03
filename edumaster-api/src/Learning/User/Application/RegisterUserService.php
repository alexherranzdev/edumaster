<?php

declare(strict_types=1);

namespace Edumaster\Learning\User\Application;

use Edumaster\Learning\User\Domain\Exception\UserAlreadyExistsException;
use Edumaster\Learning\User\Domain\UserRepository;
use Edumaster\Learning\User\Domain\User;
use Edumaster\Learning\User\Domain\ValueObject\UserId;
use Edumaster\Shared\ValueObject\Email;
use Illuminate\Support\Facades\Hash;

class RegisterUserService
{
  public function __construct(private UserRepository $repository) {}

  public function execute(string $name, string $email, string $password, string $role): User
  {
    if (!in_array($role, ['teacher', 'student'])) {
      throw new \InvalidArgumentException("Invalid role: {$role}");
    }

    $email = new Email($email);

    if ($this->repository->findByEmail($email->value())) {
      throw new UserAlreadyExistsException($email->value());
    }

    $user = new User([
      'user_id' => (new UserId())->value(),
      'name' => $name,
      'email' => $email->value(),
      'password' => Hash::make($password),
      'role' => $role
    ]);

    $this->repository->save($user);

    return $user;
  }
}
