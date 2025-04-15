<?php

declare(strict_types=1);

namespace Edumaster\Shared\Domain\Bus\Event;

use DateTimeImmutable;
use Edumaster\Shared\Domain\Utils;

abstract class DomainEvent
{
	private readonly string $occurredOn;

	public function __construct(private readonly string $aggregateId, string $occurredOn = null)
	{
		$this->occurredOn = $occurredOn ?: Utils::dateToString(new DateTimeImmutable());
	}

	final public function aggregateId(): string
	{
		return $this->aggregateId;
	}

	final public function occurredOn(): string
	{
		return $this->occurredOn;
	}
}
