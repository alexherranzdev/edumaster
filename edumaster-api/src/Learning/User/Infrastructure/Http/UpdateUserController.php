<?php

declare(strict_types=1);

namespace Edumaster\Learning\User\Infrastructure\Http;

use Edumaster\Learning\User\Application\Update\UpdateUserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UpdateUserController
{
  public function __construct(private UpdateUserService $service) {}

  public function execute(Request $request, string $id): JsonResponse
  {
    $this->service->execute($id, $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email',
      'password' => 'nullable|string|min:8',
    ]));

    return response()->json(null, 204);
  }
}
