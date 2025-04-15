<?php

declare(strict_types=1);

namespace Tests\RoomFlow\Room\Domain;

use Edumaster\RoomFlow\Room\Application\Create\CreateRoomCommand;
use Edumaster\RoomFlow\Room\Domain\Room;
use Edumaster\RoomFlow\Room\Domain\ValueObject\RoomId;

final class RoomMother
{
	public static function create(
		?RoomId $id = null,
		?string $name = null
	): Room
	{
		return new Room(
			$id ?? RoomIdMother::create(),
			$name ?? 'Room Name'
		);
	}

	public static function fromRequest(CreateRoomCommand $request): Room
	{
		return self::create(
			new RoomId($request->id()),
			$request->name()
		);
	}
}
