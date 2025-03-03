<?php

declare(strict_types=1);

namespace Edumaster\Learning\User\Domain;

use Database\Factories\UserFactory;
use Edumaster\Learning\User\Domain\ValueObject\UserId;
use Edumaster\Shared\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasUuid, HasFactory;

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

  protected static function newFactory()
  {
    return UserFactory::new();
  }
}
