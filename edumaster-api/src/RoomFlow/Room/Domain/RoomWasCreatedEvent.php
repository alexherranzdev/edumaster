<?php

declare(strict_types=1);

namespace Edumaster\RoomFlow\Room\Domain;

final class RoomWasCreated
{
	private string $roomId;
	private string $name;

	public function __construct(string $roomId, string $name)
	{
		$this->roomId = $roomId;
		$this->name = $name;
	}

	public function roomId(): string
	{
		return $this->roomId;
	}

	public function name(): string
	{
		return $this->name;
	}
}
