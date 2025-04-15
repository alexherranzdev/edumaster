<?php

declare(strict_types=1);

namespace Edumaster\RoomFlow\Room\Infrastructure\Persistence;

use Edumaster\RoomFlow\Room\Domain\Room;
use Edumaster\RoomFlow\Room\Domain\RoomRepository;
use Edumaster\RoomFlow\Room\Domain\ValueObject\RoomId;

final class InMemoryRoomRepository implements RoomRepository
{
	private array $rooms = [];

	public function save(Room $room): void
	{
		$this->rooms[$room->id()->value()] = $room;
	}

	public function search(RoomId $id): ?Room
	{
		return $this->rooms[$id->value()] ?? null;
	}
}
