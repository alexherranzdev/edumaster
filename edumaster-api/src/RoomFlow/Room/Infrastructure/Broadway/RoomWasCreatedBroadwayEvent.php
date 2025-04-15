<?php

declare(strict_types=1);

namespace Edumaster\RoomFlow\Room\Infrastructure\Broadway;

use Broadway\Serializer\Serializable;
use Edumaster\RoomFlow\Room\Domain\RoomWasCreated;

final class RoomWasCreatedBroadwayEvent implements Serializable
{
	private string $roomId;
	private string $name;

	public function __construct(string $roomId, string $name)
	{
		$this->roomId = $roomId;
		$this->name = $name;
	}

	public static function fromDomainEvent(RoomWasCreated $event): self
	{
		return new self($event->roomId(), $event->name());
	}

	public function toDomainEvent(): RoomWasCreated
	{
		return new RoomWasCreated($this->roomId, $this->name);
	}

	public static function deserialize(array $data): self
	{
		return new self($data['roomId'], $data['name']);
	}

	public function serialize(): array
	{
		return [
			'roomId' => $this->roomId,
			'name' => $this->name,
		];
	}
}
