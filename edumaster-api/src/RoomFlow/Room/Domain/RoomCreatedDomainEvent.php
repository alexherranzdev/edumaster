<?php

declare(strict_types=1);

namespace Edumaster\RoomFlow\Room\Domain;

use Edumaster\Shared\Domain\Bus\Event\DomainEvent;

final class RoomCreatedDomainEvent extends DomainEvent
{
	public function __construct(private string $roomId, private string $name) {
		parent::__construct($roomId);
	}

	public function name(): string
	{
		return $this->name;
	}
}
