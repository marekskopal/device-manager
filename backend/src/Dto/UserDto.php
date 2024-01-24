<?php

declare(strict_types=1);

namespace DeviceManager\Dto;

use DeviceManager\Model\Entity\User;

final readonly class UserDto
{
	public function __construct(public int $id, public string $email, public string $name,)
	{
	}

	public static function fromEntity(User $entity): self
	{
		return new self(
			id: $entity->getId(),
			email: $entity->getEmail(),
			name: $entity->getName(),
		);
	}

	/**
	 * @param array{
	 *     id: int,
	 *     email: string,
	 *     name: string,
	 * } $data
	 */
	public static function fromArray(array $data): self
	{
		return new self(id: $data['id'], email: $data['email'], name: $data['name']);
	}
}
