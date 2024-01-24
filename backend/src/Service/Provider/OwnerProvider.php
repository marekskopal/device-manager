<?php

declare(strict_types=1);

namespace DeviceManager\Service\Provider;

use DeviceManager\Model\Entity\Owner;
use DeviceManager\Model\Repository\OwnerRepository;

class OwnerProvider
{
	public function __construct(private readonly OwnerRepository $ownerRepository)
	{
	}

	/** @return iterable<Owner> */
	public function getOwners(): iterable
	{
		return $this->ownerRepository->findOwners();
	}

	public function getOwner(int $ownerId): ?Owner
	{
		return $this->ownerRepository->findOwnerById($ownerId);
	}

	public function createOwner(string $firstName, string $lastName): Owner
	{
		$owner = new Owner(firstName: $firstName, lastName: $lastName);
		$this->ownerRepository->persist($owner);

		return $owner;
	}

	public function updateOwner(Owner $owner, string $firstName, string $lastName): Owner
	{
		$owner->setFirstName($firstName);
		$owner->setLastName($lastName);
		$this->ownerRepository->persist($owner);

		return $owner;
	}

	public function deleteOwner(Owner $owner): void
	{
		$this->ownerRepository->delete($owner);
	}
}
