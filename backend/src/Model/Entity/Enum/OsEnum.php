<?php

declare(strict_types=1);

namespace DeviceManager\Model\Entity\Enum;

enum OsEnum: string
{
	case Windows = 'windows';
	case Linux = 'linux';
	case MacOS = 'macos';
	case IOs = 'ios';
	case Android = 'android';
}
