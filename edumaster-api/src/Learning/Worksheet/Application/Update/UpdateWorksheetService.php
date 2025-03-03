<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Application\Update;

use Edumaster\Learning\Worksheet\Domain\Exception\WorksheetNotFoundException;
use Edumaster\Learning\Worksheet\Domain\ValueObject\WorksheetId;
use Edumaster\Learning\Worksheet\Domain\ValueObject\QuestionId;
use Edumaster\Learning\Worksheet\Domain\WorksheetQuestion;
use Edumaster\Learning\Worksheet\Domain\WorksheetRepository;

class UpdateWorksheetService
{
  public function __construct(private WorksheetRepository $repository) {}

  public function execute(string $id, UpdateWorksheetRequest $request): void
  {
    $worksheet = $this->repository->findById(new WorksheetId($id));
    if (!$worksheet) {
      throw new WorksheetNotFoundException("Worksheet not found.");
    }

    $worksheet->title = $request->title();
    $worksheet->description = $request->description();

    $updatedQuestionIds = array_map(fn($q) => $q['question_id'], $request->questions());

    foreach ($worksheet->questions as $existingQuestion) {
      if (!in_array($existingQuestion->question_id, $updatedQuestionIds)) {
        $worksheet->removeQuestion($existingQuestion);
      }
    }

    foreach ($request->questions() as $questionData) {
      $questionId = new QuestionId($questionData['question_id'] ?? null);
      $question = $worksheet->findQuestionById($questionId);

      if ($question) {
        $question->updateQuestion(
          $questionData['question'],
          $questionData['words'],
          $questionData['correct_word']
        );

        $worksheet->replaceQuestion($question);
      } else {
        $newQuestion = new WorksheetQuestion();
        $newQuestion->question_id = $questionId->value();
        $newQuestion->worksheet_id = (new WorksheetId($id))->value();
        $newQuestion->question = $questionData['question'];
        $newQuestion->words = $questionData['words'];
        $newQuestion->correct_word = $questionData['correct_word'];

        $worksheet->addQuestion($newQuestion);
      }
    }

    $this->repository->save($worksheet);
  }
}
