<?php

declare(strict_types=1);

namespace Edumaster\Learning\User\Application;

use Edumaster\Learning\User\Domain\UserRepository;
use Illuminate\Support\Facades\Auth;

class AuthService
{
  public function __construct(private UserRepository $userRepository) {}

  public function login(array $data): array
  {
    if (!Auth::attempt($data)) {
      throw new \Exception("Credenciales incorrectas");
    }

    $user = Auth::user();
    return [
      'token' => $user->createToken('API Token')->plainTextToken,
      'user' => $user
    ];
  }

  public function logout(): void
  {
    Auth::user()->tokens()->delete();
  }
}
