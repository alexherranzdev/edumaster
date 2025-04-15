<?php

declare(strict_types=1);

namespace Edumaster\Shared\Infrastructure\Bus\Command;

use Broadway\CommandHandling\CommandHandler;

final class BroadwayCommandHandler implements CommandHandler
{
    public function __construct(
        private object $handler,
        private ?string $expectedCommandClass = null
    ) {}

    public function handle($command): void
    {
        if ($this->expectedCommandClass && !$command instanceof $this->expectedCommandClass) {
            throw new \InvalidArgumentException(
                sprintf('Expected command of type %s, got %s', $this->expectedCommandClass, get_class($command))
            );
        }

        ($this->handler)($command);
    }
}