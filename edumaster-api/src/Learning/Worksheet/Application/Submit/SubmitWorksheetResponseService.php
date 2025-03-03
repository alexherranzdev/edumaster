<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Application\Submit;

use Edumaster\Learning\User\Domain\ValueObject\UserId;
use Edumaster\Learning\Worksheet\Domain\Exception\WorksheetNotFoundException;
use Edumaster\Learning\Worksheet\Domain\ValueObject\QuestionId;
use Edumaster\Learning\Worksheet\Domain\ValueObject\ResponseId;
use Edumaster\Learning\Worksheet\Domain\ValueObject\WorksheetId;
use Edumaster\Learning\Worksheet\Domain\ValueObject\WorksheetStatus;
use Edumaster\Learning\Worksheet\Domain\WorksheetRepository;
use Edumaster\Learning\Worksheet\Domain\WorksheetResponse;
use Edumaster\Learning\Worksheet\Domain\WorksheetResponseRepository;
use Edumaster\Learning\Worksheet\Domain\WorksheetStudent;
use Edumaster\Learning\Worksheet\Domain\WorksheetStudentRepository;

class SubmitWorksheetResponseService
{

  public function __construct(
    private WorksheetResponseRepository $repository,
    private WorksheetRepository $worksheetRepository,
    private WorksheetStudentRepository $worksheetStudentRepository
  ) {}

  public function execute(string $worksheetId, string $userId, array $responses): void
  {
    $worksheet = $this->worksheetRepository->findById(new WorksheetId($worksheetId));
    if (!$worksheet) {
      throw new WorksheetNotFoundException($worksheetId);
    }

    $worksheetId = new WorksheetId($worksheetId);
    $this->repository->deleteByWorksheetId($worksheetId);

    $studentId = new UserId($userId);

    foreach ($responses as $responseData) {
      $questionId = new QuestionId($responseData['question_id']);
      $question = $worksheet->findQuestionById($questionId);
      if (!$question) {
        continue;
      }

      $responseId = new ResponseId();
      $selectedWord = $responseData['selected_word'];
      $correctWord = $question->correct_word;
      $isCorrect = $selectedWord === $correctWord;

      $response = new WorksheetResponse();
      $response->response_id = $responseId->value();
      $response->worksheet_id = $worksheetId->value();
      $response->question_id = $questionId->value();
      $response->student_id = $studentId->value();
      $response->selected_word = $selectedWord;
      $response->is_correct = $isCorrect;

      $this->repository->save($response);
    }

    if (count($responses) === count($worksheet->questions)) {
      $this->worksheetStudentRepository->save(new WorksheetStudent($worksheetId, $studentId, WorksheetStatus::COMPLETED));
    } else {
      $this->worksheetStudentRepository->save(new WorksheetStudent($worksheetId, $studentId, WorksheetStatus::IN_PROGRESS));
    }
  }
}
