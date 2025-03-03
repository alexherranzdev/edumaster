<?php

declare(strict_types=1);

namespace Edumaster\Learning\Worksheet\Application\Update;

class UpdateWorksheetRequest
{
  public function __construct(
    private string $title,
    private ?string $description,
    private array $questions,
    private string $teacher_id
  ) {}

  public function title(): string
  {
    return $this->title;
  }

  public function description(): ?string
  {
    return $this->description;
  }

  public function questions(): array
  {
    return $this->questions;
  }

  public function teacherId(): string
  {
    return $this->teacher_id;
  }
}
