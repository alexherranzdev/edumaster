<?php

declare(strict_types=1);

namespace Edumaster\Shared\Infrastructure\Bus\Event\Broadway;

use Broadway\Domain\DomainEventStream;
use Edumaster\Shared\Domain\Bus\Event\DomainEvent;
use Edumaster\Shared\Domain\Bus\Event\EventBus;
use Broadway\EventHandling\EventBus as BroadwayEventBusInterface;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;

final class BroadwayEventBus implements EventBus
{
	public function __construct(private BroadwayEventBusInterface $eventBus) {}

	public function publish(DomainEvent ...$events): void
    {
        $domainMessages = [];

        foreach ($events as $event) {
            $domainMessages[] = DomainMessage::recordNow(
                $event->aggregateId(),
                0,
                new Metadata([]),
                $event
            );
        }

        $this->eventBus->publish(new DomainEventStream($domainMessages));
    }
}
