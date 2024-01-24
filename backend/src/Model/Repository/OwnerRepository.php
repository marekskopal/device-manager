<?php

declare(strict_types=1);

namespace DeviceManager\Model\Repository;

use DeviceManager\Model\Entity\Owner;

/** @extends ARepository<Owner> */
class OwnerRepository extends ARepository
{
	/** @return iterable<Owner> */
	public function findOwners(): iterable
	{
		return $this->findAll();
	}

	public function findOwnerById(int $ownerId): ?Owner
	{
		return $this->findOne([
			'id' => $ownerId,
		]);
	}
}
