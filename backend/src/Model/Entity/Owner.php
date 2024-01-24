<?php

declare(strict_types=1);

namespace DeviceManager\Model\Entity;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use DeviceManager\Model\Repository\OwnerRepository;

#[Entity(repository: OwnerRepository::class)]
class Owner extends AEntity
{
	public function __construct(#[Column(type: 'string')] private string $firstName, #[Column(type: 'string')] private string $lastName,)
	{
	}

	public function getFirstName(): string
	{
		return $this->firstName;
	}

	public function setFirstName(string $firstName): void
	{
		$this->firstName = $firstName;
	}

	public function getLastName(): string
	{
		return $this->lastName;
	}

	public function setLastName(string $lastName): void
	{
		$this->lastName = $lastName;
	}
}
