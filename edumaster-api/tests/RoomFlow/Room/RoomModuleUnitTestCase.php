<?php

declare(strict_types=1);

namespace Tests\RoomFlow\Room;

use Edumaster\RoomFlow\Room\Domain\Room;
use Edumaster\RoomFlow\Room\Domain\RoomRepository;
use Edumaster\RoomFlow\Room\Domain\ValueObject\RoomId;
use Mockery\MockInterface;
use Tests\Shared\Infrastructure\PHPUnit\UnitTestCase;

abstract class RoomModuleUnitTestCase extends UnitTestCase
{
	private RoomRepository | MockInterface | null $repository = null;

	protected function shouldSave(Room $expectedRoom): void
	{
		$this->repository()
			->shouldReceive('save')
			->once()
			->withArgs(function (Room $room) use ($expectedRoom) {
				return $room->id()->equals($expectedRoom->id())
					&& $room->name() === $expectedRoom->name();
			})
			->andReturnNull();
	}



    protected function shouldSaveByName(string $expectedName): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->once()
            ->withArgs(function (Room $room) use ($expectedName) {
                return $room->name() === $expectedName;
            })
            ->andReturnNull();
    }

	protected function shouldSearch(RoomId $id, ?Room $room): void
	{
		$this->repository()
			->shouldReceive('search')
			->with($this->similarTo($id))
			->once()
			->andReturn($room);
	}

	protected function repository(): RoomRepository | MockInterface
	{
		return $this->repository ??= $this->mock(RoomRepository::class);
	}
}
