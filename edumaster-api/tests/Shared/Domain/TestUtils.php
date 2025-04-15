<?php

declare(strict_types=1);

namespace Tests\Shared\Domain;

use PHPUnit\Framework\Constraint\Constraint;

final class TestUtils
{
	public static function isSimilar(mixed $expected, mixed $actual): bool
	{
		$constraint = new Constraint($expected);

		return $constraint->evaluate($actual, '', true);

	}

	public static function assertSimilar(mixed $expected, mixed $actual): void
	{
		$constraint = new Constraint($expected);

		$constraint->evaluate($actual);
	}

	public static function similarTo(mixed $value, float $delta = 0.0): Constraint
	{
		return new Constraint($value, $delta);
	}
}
