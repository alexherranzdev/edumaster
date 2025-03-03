<?php

declare(strict_types=1);

namespace Edumaster\Shared\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
  protected static function bootHasUuid()
  {
    static::creating(function ($model) {
      if (!$model->user_id) {
        $model->user_id = Str::uuid()->toString();
      }
    });
  }

  public function getIncrementing(): bool
  {
    return false;
  }

  public function getKeyType(): string
  {
    return 'string';
  }
}
