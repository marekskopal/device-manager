<?php

declare(strict_types=1);

namespace DeviceManager\Dto;

use SensitiveParameter;

final readonly class UserCreateDto
{
	public function __construct(
		#[SensitiveParameter] public string $email,
		#[SensitiveParameter] public string $password,
		public string $name,
	) {
	}

	/**
	 * @param array{
	 *     email: string,
	 *     name: string,
	 *     password: string,
	 * } $data
	 */
	public static function fromArray(array $data): self
	{
		return new self(email: $data['email'], name: $data['name'], password: $data['password']);
	}
}
