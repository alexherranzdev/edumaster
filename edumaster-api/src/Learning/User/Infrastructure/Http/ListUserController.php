<?php

declare(strict_types=1);

namespace Edumaster\Learning\User\Infrastructure\Http;

use Edumaster\Learning\User\Application\List\ListUsersByRoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListUserController
{
  public function __construct(private ListUsersByRoleService $service) {}

  public function listByRole(Request $request): JsonResponse
  {
    $users = $this->service->execute(
      $request->query('role', 'student'),
      (int)$request->query('limit', 100),
      (int)$request->query('offset', 0)
    );

    return response()->json($users);
  }
}
