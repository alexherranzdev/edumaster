<?php

declare(strict_types=1);

namespace App\Providers;

use Broadway\CommandHandling\SimpleCommandBus as BroadwaySimpleCommandBus;
use Broadway\EventHandling\EventBus as BroadwayBaseEventBus;
use Broadway\EventHandling\SimpleEventBus;
use Broadway\EventStore\InMemoryEventStore;
use Edumaster\RoomFlow\Room\Application\Create\CreateRoomCommand;
use Edumaster\RoomFlow\Room\Application\Create\CreateRoomCommandHandler;
use Edumaster\RoomFlow\Room\Application\Create\RoomCreator;
use Edumaster\Shared\Domain\Bus\Command\CommandBus;
use Edumaster\Shared\Domain\Bus\Event\EventBus;
use Edumaster\Shared\Infrastructure\Bus\Command\BroadwayCommandBus;
use Edumaster\Shared\Infrastructure\Bus\Command\BroadwayCommandHandler;
use Edumaster\Shared\Infrastructure\Bus\Command\CommandHandlerMap;
use Edumaster\Shared\Infrastructure\Bus\Event\Broadway\BroadwayEventBus;
use Illuminate\Support\ServiceProvider;

final class BroadwayServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		// CommandBus
		$this->app->singleton(BroadwaySimpleCommandBus::class, fn () => new BroadwaySimpleCommandBus());

		$this->app->singleton(CommandBus::class, function ($app) {
			$broadwayCommandBus = $app->make(BroadwaySimpleCommandBus::class);

			foreach (CommandHandlerMap::get() as $command => $handler) {
				$broadwayCommandBus->subscribe(
					new BroadwayCommandHandler(
						$app->make($handler),
						$command
					)
				);
			}

			return new BroadwayCommandBus($broadwayCommandBus);
		});


		// EventBus
        $this->app->singleton(BroadwayBaseEventBus::class, fn () => new SimpleEventBus());

        $this->app->singleton(EventBus::class, function ($app) {
            return new BroadwayEventBus(
                $app->make(BroadwayBaseEventBus::class)
            );
        });

		// EventStore
		$this->app->singleton(InMemoryEventStore::class, fn () => new InMemoryEventStore());
	}

	public function boot(): void
	{
		//
	}
}
