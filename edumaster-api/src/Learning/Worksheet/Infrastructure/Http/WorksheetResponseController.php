<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Infrastructure\Http;

use Edumaster\Learning\Worksheet\Application\Submit\SubmitWorksheetResponseService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WorksheetResponseController
{
  public function __construct(private SubmitWorksheetResponseService $service) {}

  public function store(Request $request, string $worksheetId): JsonResponse
  {
    $validated = $request->validate([
      'responses' => 'required|array',
    ]);

    $this->service->execute(
      $worksheetId,
      $request->user()->user_id->value(),
      $validated['responses']
    );

    return response()->json(['message' => 'Response submitted successfully']);
  }
}
