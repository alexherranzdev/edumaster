<?php

declare(strict_types=1);

namespace Edumaster\RoomFlow\Room\Application\Create;

use Edumaster\RoomFlow\Room\Domain\Room;
use Edumaster\RoomFlow\Room\Domain\RoomRepository;
use Edumaster\RoomFlow\Room\Domain\ValueObject\RoomId;
use Edumaster\Shared\Domain\Bus\Event\EventBus;

final readonly class RoomCreator
{
	public function __construct(
		private RoomRepository $repository,
		private EventBus $eventBus
	) {}

	public function __invoke(RoomId $id, string $name): void
	{
		$room = Room::create($id, $name);

		$this->repository->save($room);
		$this->eventBus->publish(...$room->pullDomainEvents());
	}
}
