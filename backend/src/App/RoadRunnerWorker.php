<?php

declare(strict_types=1);

namespace DeviceManager\App;

use DeviceManager\App\Dispatcher\Dispatcher;
use DeviceManager\App\Dispatcher\HttpDispatcher;
use Spiral\RoadRunner\Environment;

final class RoadRunnerWorker
{
	public function run(): void
	{
		/** @var list<Dispatcher> $dispatchers */
		$dispatchers = [
			new HttpDispatcher(),
		];

		$env = Environment::fromGlobals();

		foreach ($dispatchers as $dispatcher) {
			if (!$dispatcher->canServe($env)) {
				continue;
			}

			$dispatcher->serve();
		}
	}
}
