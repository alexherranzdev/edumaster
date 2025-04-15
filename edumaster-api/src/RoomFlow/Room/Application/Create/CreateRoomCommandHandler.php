<?php

declare(strict_types=1);

namespace Edumaster\RoomFlow\Room\Application\Create;

use Edumaster\RoomFlow\Room\Domain\ValueObject\RoomId;
use Edumaster\Shared\Domain\Bus\Command\CommandHandler;

final readonly class CreateRoomCommandHandler
{
	public function __construct(private RoomCreator $creator) {}

	public function __invoke(CreateRoomCommand $command): void
	{
		$id = new RoomId($command->id());
		$name = $command->name();

		$this->creator->__invoke($id, $name);
	}
}
