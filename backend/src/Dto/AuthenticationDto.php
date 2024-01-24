<?php

declare(strict_types=1);

namespace DeviceManager\Dto;

final readonly class AuthenticationDto
{
	public function __construct(public string $token, public int $tokenExpirationTime, public int $userId)
	{
	}
}
