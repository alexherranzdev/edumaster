<?php

declare(strict_types=1);

namespace Edumaster\Shared\Domain\ValueObject;

use InvalidArgumentException;

final class Email
{
	private string $email;

	public function __construct(string $email)
	{
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new InvalidArgumentException("El email '{$email}' no es válido.");
		}

		$this->email = strtolower(trim($email));
	}

	public function value(): string
	{
		return $this->email;
	}

	public function __toString(): string
	{
		return $this->email;
	}

	public function equals(self $otherEmail): bool
	{
		return $this->email === $otherEmail->value();
	}
}
