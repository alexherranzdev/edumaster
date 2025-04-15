<?php

declare(strict_types=1);

namespace Edumaster\Shared\Infrastructure\Laravel;

use Edumaster\Shared\Domain\Bus\Command\Command;
use Edumaster\Shared\Domain\Bus\Command\CommandBus;

abstract class ApiController
{
	public function __construct(
		private readonly CommandBus $commandBus
	) {}protected function dispatch(Command $command): void
	{
		$this->commandBus->dispatch($command);
	}
}
