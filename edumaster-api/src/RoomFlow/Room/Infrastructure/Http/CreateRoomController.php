<?php

declare(strict_types=1);

namespace Edumaster\RoomFlow\Room\Infrastructure\Http;

use Edumaster\RoomFlow\Room\Application\Create\CreateRoomCommand;
use Edumaster\Shared\Infrastructure\Laravel\ApiController;
use Illuminate\Http\Request;

final class CreateRoomController extends ApiController
{
	public function execute(Request $request): void
	{
		$this->dispatch(new CreateRoomCommand((string) $request->input('id'), (string) $request->input('name')));
	}
}
