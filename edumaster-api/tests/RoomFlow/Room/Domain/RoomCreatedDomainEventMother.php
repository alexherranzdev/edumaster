<?php

declare(strict_types=1);

namespace Tests\RoomFlow\Room\Domain;

use Edumaster\RoomFlow\Room\Domain\Room;
use Edumaster\RoomFlow\Room\Domain\RoomCreatedDomainEvent;
use Edumaster\RoomFlow\Room\Domain\ValueObject\RoomId;
use Edumaster\Shared\Domain\Bus\Event\DomainEvent;
use Tests\RoomFlow\Room\Domain\RoomIdMother;

final class RoomCreatedDomainEventMother
{
	public static function create(
		?RoomId $roomId = null,
		?string $name = null
	) : RoomCreatedDomainEvent
	{
		return new RoomCreatedDomainEvent(
			$roomId?->value() ?? RoomIdMother::create()->value(),
			$name ?? 'Room Name'
		);
	}

	public static function fromRoom(Room $room): RoomCreatedDomainEvent
	{
		return self::create(
			$room->id(),
			$room->name()
		);
	}
}
