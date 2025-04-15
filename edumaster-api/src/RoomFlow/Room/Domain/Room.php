<?php

declare(strict_types=1);

namespace Edumaster\RoomFlow\Room\Domain;

use Edumaster\RoomFlow\Room\Domain\ValueObject\RoomId;
use Edumaster\Shared\Domain\Aggregate\AggregateRoot;

final class Room extends AggregateRoot
{
	public function __construct(
		private RoomId $id,
		private string $name
	) {}

	public static function create(RoomId $id, string $name): self
	{
		$room = new self($id, $name);

		$room->record(new RoomCreatedDomainEvent($id->value(), $name));

		return $room;
	}

	public function id(): RoomId
	{
		return $this->id;
	}

	public function name(): string
	{
		return $this->name;
	}
}
