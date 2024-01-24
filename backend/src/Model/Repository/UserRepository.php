<?php

declare(strict_types=1);

namespace DeviceManager\Model\Repository;

use DeviceManager\Model\Entity\User;

/** @extends ARepository<User> */
class UserRepository extends ARepository
{
	/** @return iterable<User> */
	public function findUsers(): iterable
	{
		return $this->findAll();
	}

	public function findUserById(int $userId): ?User
	{
		return $this->findOne([
			'id' => $userId,
		]);
	}

	public function findUserByEmail(string $email): ?User
	{
		return $this->findOne([
			'email' => $email,
		]);
	}
}
