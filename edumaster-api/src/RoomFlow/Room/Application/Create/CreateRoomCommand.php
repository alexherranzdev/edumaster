<?php

declare(strict_types=1);

namespace Edumaster\RoomFlow\Room\Application\Create;

use Edumaster\Shared\Domain\Bus\Command\Command;

final class CreateRoomCommand implements Command
{
	public function __construct(
		private string $id,
		private string $name
	) {}

	public function id(): string
	{
		return $this->id;
	}

	public function name(): string
	{
		return $this->name;
	}
}
