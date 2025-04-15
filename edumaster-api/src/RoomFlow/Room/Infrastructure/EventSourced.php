<?php

declare(strict_types=1);

namespace Edumaster\RoomFlow\Room\Infrastructure\EventSourced;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Edumaster\RoomFlow\Room\Domain\RoomWasCreated;

final class RoomAggregate extends EventSourcedAggregateRoot
{
	private string $roomId;
	private string $name;

	public static function create(string $roomId, string $name): self
	{
		$room = new self();
		$room->apply(new RoomWasCreated($roomId, $name));
		return $room;
	}

	protected function applyRoomWasCreated(RoomWasCreated $event): void
	{
		$this->roomId = $event->roomId();
		$this->name = $event->name();
	}

	public function getAggregateRootId(): string
	{
		return $this->roomId;
	}
}
