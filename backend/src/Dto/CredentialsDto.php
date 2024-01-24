<?php

declare(strict_types=1);

namespace DeviceManager\Dto;

use SensitiveParameter;

final readonly class CredentialsDto
{
	public function __construct(#[SensitiveParameter] public string $email, #[SensitiveParameter] public string $password,)
	{
	}
}
