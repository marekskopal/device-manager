<?php

declare(strict_types=1);

namespace DeviceManager\Dto;

use DeviceManager\Model\Entity\Owner;

final readonly class OwnerDto
{
	public function __construct(public int $id, public string $firstName, public string $lastName)
	{
	}

	public static function fromEntity(Owner $entity): self
	{
		return new self(
			id: $entity->getId(),
			firstName: $entity->getFirstName(),
			lastName: $entity->getLastName(),
		);
	}
}
