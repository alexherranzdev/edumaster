<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Domain\ValueObject;

enum WorksheetStatus: string
{
  case PENDING = 'pending';
  case IN_PROGRESS = 'in_progress';
  case COMPLETED = 'completed';

  public function label(): string
  {
    return match ($this) {
      self::PENDING => 'Pendiente',
      self::IN_PROGRESS => 'En progreso',
      self::COMPLETED => 'Completado',
    };
  }
}
