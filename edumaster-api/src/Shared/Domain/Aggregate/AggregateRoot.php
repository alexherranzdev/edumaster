<?php

declare(strict_types=1);

namespace Edumaster\Shared\Domain\Aggregate;

use Edumaster\Shared\Domain\Bus\Event\DomainEvent;

abstract class AggregateRoot
{
	/** @var DomainEvent[] */
	private array $recordedEvents = [];

	protected function record(DomainEvent $event): void
	{
		$this->recordedEvents[] = $event;
	}

	/**
	 * @return DomainEvent[]
	 */
	public function pullDomainEvents(): array
	{
		$events = $this->recordedEvents;
		$this->recordedEvents = [];

		return $events;
	}
}
