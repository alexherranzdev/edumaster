<?php

declare(strict_types=1);

namespace Tests\RoomFlow\Room\Domain;

use Edumaster\RoomFlow\Room\Domain\ValueObject\RoomId;
use Tests\Shared\Domain\UuidMother;

final class RoomIdMother
{
	public static function create(?string $value = null): RoomId
	{
		return new RoomId($value ?? UuidMother::create());
	}
}
