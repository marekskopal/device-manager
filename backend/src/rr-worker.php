<?php

declare(strict_types=1);

namespace DeviceManager;

use DeviceManager\App\RoadRunnerWorker;

require_once __DIR__ . '/../vendor/autoload.php';

(new RoadRunnerWorker())->run();
