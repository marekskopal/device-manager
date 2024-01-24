<?php

declare(strict_types=1);

namespace DeviceManager\Model\Entity;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use DeviceManager\Model\Repository\UserRepository;

#[Entity(repository: UserRepository::class)]
class User extends AEntity
{
	public function __construct(
		#[Column(type: 'string')]
		private string $email,
		#[Column(type: 'string')]
		private string $password,
		#[Column(type: 'string')]
		private string $name,
	) {
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function setEmail(string $email): void
	{
		$this->email = $email;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function setPassword(string $password): void
	{
		$this->password = $password;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): void
	{
		$this->name = $name;
	}
}
