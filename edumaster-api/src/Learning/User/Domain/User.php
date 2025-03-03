<?php

declare(strict_types=1);

namespace Edumaster\Learning\User\Domain;

use Edumaster\Shared\Traits\HasUuid;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasUuid;

  protected $keyType = 'int';
  public $incrementing = true;

  protected $fillable = ['user_id', 'name', 'email', 'password', 'role'];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  public function isTeacher(): bool
  {
    return $this->role === 'teacher';
  }

  public function isStudent(): bool
  {
    return $this->role === 'student';
  }
}
