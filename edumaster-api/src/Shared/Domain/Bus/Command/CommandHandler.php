<?php

declare(strict_types=1);

namespace Edumaster\Shared\Domain\Bus\Command;

interface CommandHandler
{
	public function __invoke(Command $command): void;
}
