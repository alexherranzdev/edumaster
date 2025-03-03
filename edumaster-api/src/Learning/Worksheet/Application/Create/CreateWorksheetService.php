<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Application\Create;

use Edumaster\Learning\Worksheet\Application\Create\CreateWorksheetRequest;
use Edumaster\Learning\Worksheet\Domain\ValueObject\QuestionId;
use Edumaster\Learning\Worksheet\Domain\ValueObject\WorksheetId;
use Edumaster\Learning\Worksheet\Domain\Worksheet;
use Edumaster\Learning\Worksheet\Domain\WorksheetRepository;
use Edumaster\Learning\Worksheet\Domain\WorksheetQuestion;

class CreateWorksheetService
{
  public function __construct(private WorksheetRepository $repository) {}

  public function execute(CreateWorksheetRequest $request): Worksheet
  {
    $worksheetId = new WorksheetId();

    $worksheet = new Worksheet();
    $worksheet->worksheet_id = $worksheetId->value();
    $worksheet->teacher_id = $request->teacherId();
    $worksheet->title = $request->title();
    $worksheet->description = $request->description();

    foreach ($request->questions() as $questionData) {
      $questionId = new QuestionId();

      $newQuestion = new WorksheetQuestion();
      $newQuestion->question_id = $questionId->value();
      $newQuestion->worksheet_id = $worksheetId->value();
      $newQuestion->question = $questionData['question'];
      $newQuestion->words = $questionData['words'];
      $newQuestion->correct_word = $questionData['correct_word'];

      $worksheet->addQuestion($newQuestion);
    }

    $this->repository->save($worksheet);

    return $worksheet;
  }
}
