<?php

declare(strict_types=1);

namespace DeviceManager\Model\Entity\Enum;

enum DeviceTypeEnum: string
{
	case Pc = 'pc';
	case Laptop = 'laptop';
	case Mobile = 'mobile';
}
