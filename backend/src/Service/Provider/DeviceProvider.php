<?php

declare(strict_types=1);

namespace DeviceManager\Service\Provider;

use DeviceManager\Model\Entity\Device;
use DeviceManager\Model\Entity\Enum\DeviceTypeEnum;
use DeviceManager\Model\Entity\Enum\OsEnum;
use DeviceManager\Model\Entity\Owner;
use DeviceManager\Model\Repository\DeviceRepository;

class DeviceProvider
{
	public function __construct(private readonly DeviceRepository $deviceRepository)
	{
	}

	/** @return iterable<Device> */
	public function getDevices(): iterable
	{
		return $this->deviceRepository->findDevices();
	}

	public function getDevice(int $deviceId): ?Device
	{
		return $this->deviceRepository->findDeviceById($deviceId);
	}

	public function createDevice(string $hostname, DeviceTypeEnum $type, OsEnum $os, Owner $owner): Device
	{
		$device = new Device(hostname: $hostname, type: $type->value, os: $os->value, owner: $owner);
		$this->deviceRepository->persist($device);

		return $device;
	}

	public function updateDevice(Device $device, string $hostname, DeviceTypeEnum $type, OsEnum $os, Owner $owner): Device
	{
		$device->setHostname($hostname);
		$device->setType($type->value);
		$device->setOs($os->value);
		$device->setOwner($owner);
		$this->deviceRepository->persist($device);

		return $device;
	}

	public function deleteDevice(Device $device): void
	{
		$this->deviceRepository->delete($device);
	}
}
