<?php

declare(strict_types=1);

namespace DeviceManager\Controller;

use DeviceManager\Dto\DeviceDto;
use DeviceManager\Model\Entity\Device;
use DeviceManager\Model\Entity\Enum\DeviceTypeEnum;
use DeviceManager\Model\Entity\Enum\OsEnum;
use DeviceManager\Response\NotFoundResponse;
use DeviceManager\Response\OkResponse;
use DeviceManager\Service\Provider\DeviceProvider;
use DeviceManager\Service\Provider\OwnerProvider;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use function Safe\json_decode;

class DeviceController
{
	public function __construct(private readonly DeviceProvider $deviceProvider, private readonly OwnerProvider $ownerProvider)
	{
	}

	public function actionGetDevices(ServerRequestInterface $request): ResponseInterface
	{
		$devices = array_map(
			fn (Device $device): DeviceDto => DeviceDto::fromEntity($device),
			iterator_to_array($this->deviceProvider->getDevices()),
		);

		return new JsonResponse($devices);
	}

	/** @param array{deviceId: string} $args */
	public function actionGetDevice(ServerRequestInterface $request, array $args): ResponseInterface
	{
		$deviceId = (int) $args['deviceId'];
		if ($deviceId < 1) {
			return new NotFoundResponse('Device id is required.');
		}

		$device = $this->deviceProvider->getDevice(deviceId: $deviceId);
		if ($device === null) {
			return new NotFoundResponse('Device with id "' . $deviceId . '" was not found.');
		}

		return new JsonResponse(DeviceDto::fromEntity($device));
	}

	public function actionCreateDevice(ServerRequestInterface $request): ResponseInterface
	{
		/** @var array{hostname: string, type: value-of<DeviceTypeEnum>, os: value-of<OsEnum>, ownerId: int} $requestBody */
		$requestBody = json_decode($request->getBody()->getContents(), assoc: true);

		$owner = $this->ownerProvider->getOwner(ownerId: $requestBody['ownerId']);
		if ($owner === null) {
			return new NotFoundResponse('Owner with id "' . $requestBody['ownerId'] . '" was not found.');
		}

		return new JsonResponse(DeviceDto::fromEntity($this->deviceProvider->createDevice(
			hostname: $requestBody['hostname'],
			type: DeviceTypeEnum::from($requestBody['type']),
			os: OsEnum::from($requestBody['os']),
			owner: $owner,
		)));
	}

	/** @param array{deviceId: string} $args */
	public function actionUpdateDevice(ServerRequestInterface $request, array $args): ResponseInterface
	{
		$deviceId = (int) $args['deviceId'];
		if ($deviceId < 1) {
			return new NotFoundResponse('Device id is required.');
		}

		$device = $this->deviceProvider->getDevice(deviceId: $deviceId);
		if ($device === null) {
			return new NotFoundResponse('Device with id "' . $deviceId . '" was not found.');
		}

		/** @var array{hostname: string, type: value-of<DeviceTypeEnum>, os: value-of<OsEnum>, ownerId: int} $requestBody */
		$requestBody = json_decode($request->getBody()->getContents(), assoc: true);

		$owner = $this->ownerProvider->getOwner(ownerId: $requestBody['ownerId']);
		if ($owner === null) {
			return new NotFoundResponse('Owner with id "' . $requestBody['ownerId'] . '" was not found.');
		}

		return new JsonResponse(DeviceDto::fromEntity($this->deviceProvider->updateDevice(
			$device,
			hostname: $requestBody['hostname'],
			type: DeviceTypeEnum::from($requestBody['type']),
			os: OsEnum::from($requestBody['os']),
			owner: $owner,
		)));
	}

	/** @param array{deviceId: string} $args */
	public function actionDeleteDevice(ServerRequestInterface $request, array $args): ResponseInterface
	{
		$deviceId = (int) $args['deviceId'];
		if ($deviceId < 1) {
			return new NotFoundResponse('Device id is required.');
		}

		$device = $this->deviceProvider->getDevice(deviceId: $deviceId);
		if ($device === null) {
			return new NotFoundResponse('Device with id "' . $deviceId . '" was not found.');
		}

		$this->deviceProvider->deleteDevice($device);

		return new OkResponse();
	}
}
