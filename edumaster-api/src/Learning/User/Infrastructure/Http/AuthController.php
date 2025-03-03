<?php

declare(strict_types=1);

namespace Edumaster\Learning\User\Infrastructure\Http;

use Edumaster\Learning\User\Application\AuthService;
use Edumaster\Learning\User\Application\RegisterUserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController
{
  public function __construct(
    private AuthService $authService,
    private RegisterUserService $registerUserService
  ) {}

  public function register(Request $request): JsonResponse
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email',
      'password' => 'required|string|min:8',
      'role' => 'required|in:teacher,student',
    ]);

    $user = $this->registerUserService->execute(
      $validated['name'],
      $validated['email'],
      $validated['password'],
      $validated['role']
    );

    return response()->json([
      'message' => 'User registered successfully',
      'user' => $user
    ], 201);
  }

  public function login(Request $request): JsonResponse
  {
    $data = $this->authService->login($request->only(['email', 'password']));
    return response()->json($data);
  }

  public function logout(Request $request): JsonResponse
  {
    $this->authService->logout();
    return response()->json(['message' => 'Successfully logged out']);
  }
}
