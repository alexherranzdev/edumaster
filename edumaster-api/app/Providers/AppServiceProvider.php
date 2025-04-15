<?php

declare(strict_types=1);

namespace App\Providers;

use Edumaster\Learning\User\Domain\UserRepository;
use Edumaster\Learning\User\Infrastructure\Persistence\EloquentUserRepository;
use Edumaster\Learning\Worksheet\Domain\WorksheetRepository;
use Edumaster\Learning\Worksheet\Domain\WorksheetResponseRepository;
use Edumaster\Learning\Worksheet\Domain\WorksheetStudentRepository;
use Edumaster\Learning\Worksheet\Infrastructure\Persistence\EloquentWorksheetRepository;
use Edumaster\Learning\Worksheet\Infrastructure\Persistence\EloquentWorksheetResponseRepository;
use Edumaster\Learning\Worksheet\Infrastructure\Persistence\EloquentWorksheetStudentRepository;
use Edumaster\RoomFlow\Room\Domain\RoomRepository;
use Edumaster\RoomFlow\Room\Infrastructure\Persistence\InMemoryRoomRepository;
use Edumaster\Shared\Domain\UuidGenerator;
use Edumaster\Shared\Infrastructure\RamseyUuidGenerator;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		$this->app->bind(UuidGenerator::class, RamseyUuidGenerator::class);

		$this->app->bind(UserRepository::class, EloquentUserRepository::class);
		$this->app->bind(WorksheetRepository::class, EloquentWorksheetRepository::class);
		$this->app->bind(WorksheetResponseRepository::class, EloquentWorksheetResponseRepository::class);
		$this->app->bind(WorksheetStudentRepository::class, EloquentWorksheetStudentRepository::class);
		$this->app->bind(RoomRepository::class, InMemoryRoomRepository::class);
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		//
	}
}
