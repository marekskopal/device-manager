<?php

declare(strict_types=1);

namespace DeviceManager\Model\Repository;

use DeviceManager\Model\Entity\Device;

/** @extends ARepository<Device> */
class DeviceRepository extends ARepository
{
	/** @return iterable<Device> */
	public function findDevices(): iterable
	{
		return $this->findAll();
	}

	public function findDeviceById(int $ownerId): ?Device
	{
		return $this->findOne([
			'id' => $ownerId,
		]);
	}
}
