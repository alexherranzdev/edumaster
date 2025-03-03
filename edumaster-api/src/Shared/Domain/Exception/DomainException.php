<?php

declare(strict_types=1);

namespace Edumaster\Shared\Domain\Exception;

use Exception;

abstract class DomainException extends Exception
{
  private string $errorCode;

  public function __construct(string $message, string $errorCode, int $statusCode = 400)
  {
    parent::__construct($message, $statusCode);
    $this->errorCode = $errorCode;
  }

  public function errorCode(): string
  {
    return $this->errorCode;
  }
}
