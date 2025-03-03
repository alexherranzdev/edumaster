<?php

declare(strict_types=1);

namespace Edumaster\Shared\ValueObject;

use Ramsey\Uuid\Uuid as RamseyUuid;
use Stringable;

abstract class Uuid implements Stringable
{
  protected string $id;

  public function __construct(?string $id = null)
  {
    $this->id = $id ?? RamseyUuid::uuid4()->toString();
  }

  public function __toString(): string
  {
    return $this->id;
  }

  public function value(): string
  {
    return $this->id;
  }

  public function equals(self $other): bool
  {
    return $this->id === (string) $other;
  }

  public static function generate(): self
  {
    return new static();
  }
}
