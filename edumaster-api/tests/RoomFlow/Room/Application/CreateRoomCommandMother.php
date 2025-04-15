<?php

declare(strict_types=1);

namespace Tests\RoomFlow\Room\Application;

use Edumaster\RoomFlow\Room\Application\Create\CreateRoomCommand;
use Edumaster\RoomFlow\Room\Domain\ValueObject\RoomId;
use Tests\RoomFlow\Room\Domain\RoomIdMother;

final class CreateRoomCommandMother
{
    public static function create(
        ?RoomId $roomId = null,
        ?string $name = null
    ): CreateRoomCommand
    {
        return new CreateRoomCommand(
            $roomId?->value() ?? RoomIdMother::create()->value(),
            $name ?? 'Room Name'
        );
    }
}