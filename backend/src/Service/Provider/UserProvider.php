<?php

declare(strict_types=1);

namespace DeviceManager\Service\Provider;

use DeviceManager\Model\Entity\User;
use DeviceManager\Model\Repository\UserRepository;

class UserProvider
{
	public function __construct(private readonly UserRepository $userRepository,)
	{
	}

	public function getUser(int $userId): ?User
	{
		return $this->userRepository->findUserById($userId);
	}

	public function getUserByEmail(string $email): ?User
	{
		return $this->userRepository->findUserByEmail($email);
	}
}
