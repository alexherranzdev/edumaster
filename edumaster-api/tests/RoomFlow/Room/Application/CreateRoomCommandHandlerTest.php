<?php

declare(strict_types=1);

namespace Tests\RoomFlow\Room\Application;

use Edumaster\RoomFlow\Room\Application\Create\CreateRoomCommandHandler;
use Edumaster\RoomFlow\Room\Application\Create\RoomCreator;
use Tests\RoomFlow\Room\Domain\RoomCreatedDomainEventMother;
use Tests\RoomFlow\Room\Domain\RoomMother;
use Tests\RoomFlow\Room\RoomModuleUnitTestCase;

final class CreateRoomCommandHandlerTest extends RoomModuleUnitTestCase
{
    private CreateRoomCommandHandler | null $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new CreateRoomCommandHandler(new RoomCreator($this->repository(), $this->eventBus()));
    }

    /** @test */
    public function it_should_create_a_room(): void
    {
        $command = CreateRoomCommandMother::create();
        $room = RoomMother::fromRequest($command);
        $domainEvent = RoomCreatedDomainEventMother::fromRoom($room);

        $this->shouldSaveByName($room->name());
        $this->shouldPublishDomainEvent($domainEvent);
		$this->dispatch($command, $this->handler);
    }
}
