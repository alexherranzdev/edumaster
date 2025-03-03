<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Infrastructure\Http;

use Edumaster\Learning\Worksheet\Application\Create\CreateWorksheetService;
use Edumaster\Learning\Worksheet\Application\Find\FindWorksheetService;
use Edumaster\Learning\Worksheet\Application\Delete\DeleteWorksheetService;
use Edumaster\Learning\Worksheet\Application\List\ListWorksheetsService;
use Edumaster\Learning\Worksheet\Application\Create\CreateWorksheetRequest;
use Edumaster\Learning\Worksheet\Application\Update\UpdateWorksheetRequest;
use Edumaster\Learning\Worksheet\Application\Update\UpdateWorksheetService;
use Edumaster\Learning\Worksheet\Domain\Exception\WorksheetNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorksheetController
{
  public function __construct(
    private CreateWorksheetService $createWorksheetService,
    private FindWorksheetService $findWorksheetService,
    private UpdateWorksheetService $updateWorksheetService,
    private ListWorksheetsService $listWorksheetsService,
    private DeleteWorksheetService $deleteWorksheetService
  ) {}

  public function store(Request $request): JsonResponse
  {
    $validated = $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'nullable|string',
      'questions' => 'required|array|min:1',
      'questions.*.question' => 'required|string',
      'questions.*.words' => 'required|array|min:1',
      'questions.*.correct_word' => 'required|string'
    ]);

    $createRequest = new CreateWorksheetRequest(
      $validated['title'],
      $validated['description'],
      $validated['questions'],
      $request->user()->user_id
    );

    $worksheet = $this->createWorksheetService->execute($createRequest);

    return response()->json($worksheet, 201);
  }

  public function show(string $id): JsonResponse
  {
    $worksheet = $this->findWorksheetService->execute($id);

    return response()->json($worksheet);
  }

  public function index(Request $request): JsonResponse
  {
    $with = ['questions'];
    if ($request->has('with')) {
      $with = explode(',', $request->query('with'));
    }

    $worksheets = $this->listWorksheetsService->execute(
      $request->user()->user_id,
      $request->user()->role,
      (int)$request->query('limit', 10),
      (int)$request->query('offset', 0),
      $with
    );

    return response()->json($worksheets);
  }

  public function destroy(string $id): JsonResponse
  {
    try {
      $this->deleteWorksheetService->execute($id);
    } catch (\Exception $e) {
      // TODO: Not found
    }

    return response()->json(null, 204);
  }

  public function update(Request $request, string $id): JsonResponse
  {
    try {
      $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'questions' => 'required|array|min:1',
        'questions.*.question_id' => 'required|string',
        'questions.*.question' => 'required|string',
        'questions.*.words' => 'required|array|min:1',
        'questions.*.correct_word' => 'required|string'
      ]);

      $updateRequest = new UpdateWorksheetRequest(
        $validated['title'],
        $validated['description'],
        $validated['questions'],
        $request->user()->user_id
      );

      $this->updateWorksheetService->execute($id, $updateRequest);

      return response()->json(['message' => 'Worksheet updated successfully']);
    } catch (WorksheetNotFoundException $e) {
      return response()->json(['message' => 'Worksheet not found'], 404);
    } catch (\Exception $ex) {
      return response()->json(['message' => 'An error occurred: ' . $ex->getMessage()], 500);
    }
  }
}
