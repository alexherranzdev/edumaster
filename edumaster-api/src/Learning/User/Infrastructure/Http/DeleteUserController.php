<?php

declare(strict_types=1);

namespace Edumaster\Learning\User\Infrastructure\Http;

use Edumaster\Learning\User\Application\Delete\DeleteUserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DeleteUserController
{
  public function __construct(private DeleteUserService $service) {}

  public function execute(Request $request, string $id): JsonResponse
  {
    $this->service->execute($id);
    return response()->json(null, 204);
  }
}
