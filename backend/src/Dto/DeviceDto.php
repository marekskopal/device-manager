<?php

declare(strict_types=1);

namespace DeviceManager\Dto;

use DeviceManager\Model\Entity\Device;
use DeviceManager\Model\Entity\Enum\DeviceTypeEnum;
use DeviceManager\Model\Entity\Enum\OsEnum;

final readonly class DeviceDto
{
	public function __construct(
		public int $id,
		public string $hostname,
		public DeviceTypeEnum $type,
		public OsEnum $os,
		public OwnerDto $owner,
	)
	{
	}

	public static function fromEntity(Device $entity): self
	{
		return new self(
			id: $entity->getId(),
			hostname: $entity->getHostname(),
			type: DeviceTypeEnum::from($entity->getType()),
			os: OsEnum::from($entity->getOs()),
			owner: OwnerDto::fromEntity($entity->getOwner()),
		);
	}
}
