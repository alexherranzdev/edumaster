<?php

declare(strict_types=1);

namespace Edumaster\Shared\Infrastructure\Bus\Command;

use Broadway\CommandHandling\SimpleCommandBus as BroadwaySimpleCommandBus;
use Edumaster\Shared\Domain\Bus\Command\CommandBus;

final class BroadwayCommandBus implements CommandBus
{
	public function __construct(private BroadwaySimpleCommandBus $commandBus) {}

	public function dispatch(object $command): void
	{
		$this->commandBus->dispatch($command);
	}
}
