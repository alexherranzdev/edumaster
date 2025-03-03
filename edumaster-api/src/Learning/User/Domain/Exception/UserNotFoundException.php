<?php

declare(strict_types=1);

namespace Edumaster\Learning\User\Domain\Exception;

use Edumaster\Shared\Domain\Exception\DomainException;

class UserNotFoundException extends DomainException
{
  public function __construct(string $userId)
  {
    parent::__construct(
      "User with ID {$userId} not found",
      "user_not_found",
      404
    );
  }
}
