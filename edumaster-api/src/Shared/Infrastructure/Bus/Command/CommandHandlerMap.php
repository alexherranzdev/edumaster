<?php

declare(strict_types=1);

namespace Edumaster\Shared\Infrastructure\Bus\Command;

use Edumaster\RoomFlow\Room\Application\Create\CreateRoomCommand;
use Edumaster\RoomFlow\Room\Application\Create\CreateRoomCommandHandler;

final readonly class CommandHandlerMap
{
	public static function get(): array
	{
        return [
            CreateRoomCommand::class => CreateRoomCommandHandler::class,
        ];
	}
}