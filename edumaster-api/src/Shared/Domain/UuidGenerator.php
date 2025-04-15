<?php

declare(strict_types=1);

namespace Edumaster\Shared\Domain;

interface UuidGenerator
{
	public function generate(): string;
}
