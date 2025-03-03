<?php

declare(strict_types=1);

namespace Edumaster\Learning\User\Domain\Exception;

use Edumaster\Shared\Domain\Exception\DomainException;

class UserAlreadyExistsException extends DomainException
{
  public function __construct(string $email)
  {
    parent::__construct(
      "El Email {$email} ya existe",
      "user_already_exists",
      400
    );
  }
}
