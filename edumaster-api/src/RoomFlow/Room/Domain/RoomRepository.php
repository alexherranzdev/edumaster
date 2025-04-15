<?php

declare(strict_types=1);

namespace Edumaster\RoomFlow\Room\Domain;

use Edumaster\RoomFlow\Room\Domain\ValueObject\RoomId;

interface RoomRepository
{
	public function save(Room $room): void;

	public function search(RoomId $roomId): ?Room;
}
