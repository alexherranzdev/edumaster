<?php

namespace App\Providers;

use Edumaster\Learning\User\Domain\UserRepository;
use Edumaster\Learning\User\Infrastructure\Persistence\EloquentUserRepository;
use Edumaster\Learning\Worksheet\Domain\WorksheetRepository;
use Edumaster\Learning\Worksheet\Domain\WorksheetResponseRepository;
use Edumaster\Learning\Worksheet\Domain\WorksheetStudentRepository;
use Edumaster\Learning\Worksheet\Infrastructure\Persistence\EloquentWorksheetRepository;
use Edumaster\Learning\Worksheet\Infrastructure\Persistence\EloquentWorksheetResponseRepository;
use Edumaster\Learning\Worksheet\Infrastructure\Persistence\EloquentWorksheetStudentRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(WorksheetRepository::class, EloquentWorksheetRepository::class);
        $this->app->bind(WorksheetResponseRepository::class, EloquentWorksheetResponseRepository::class);
        $this->app->bind(WorksheetStudentRepository::class, EloquentWorksheetStudentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
