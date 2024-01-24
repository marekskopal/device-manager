<?php

declare(strict_types=1);

namespace DeviceManager\Model\Entity;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\RefersTo;
use DeviceManager\Model\Repository\DeviceRepository;

#[Entity(repository: DeviceRepository::class)]
class Device extends AEntity
{
	public function __construct(
		#[Column(type: 'string')]
		private string $hostname,
		#[Column(type: 'enum(pc,laptop,mobile)')]
		private string $type,
		#[Column(type: 'enum(windows,linux,macos,ios,android)')]
		private string $os,
		#[RefersTo(target: Owner::class)]
		private Owner $owner,
	) {
	}

	public function getHostname(): string
	{
		return $this->hostname;
	}

	public function setHostname(string $hostname): void
	{
		$this->hostname = $hostname;
	}

	public function getType(): string
	{
		return $this->type;
	}

	public function setType(string $type): void
	{
		$this->type = $type;
	}

	public function getOs(): string
	{
		return $this->os;
	}

	public function setOs(string $os): void
	{
		$this->os = $os;
	}

	public function getOwner(): Owner
	{
		return $this->owner;
	}

	public function setOwner(Owner $owner): void
	{
		$this->owner = $owner;
	}
}
