<?php

declare(strict_types=1);

namespace DeviceManager\Controller;

use DeviceManager\Dto\OwnerDto;
use DeviceManager\Model\Entity\Owner;
use DeviceManager\Response\NotFoundResponse;
use DeviceManager\Response\OkResponse;
use DeviceManager\Service\Provider\OwnerProvider;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use function Safe\json_decode;

class OwnerController
{
	public function __construct(private readonly OwnerProvider $ownerProvider)
	{
	}

	public function actionGetOwners(ServerRequestInterface $request): ResponseInterface
	{
		$owners = array_map(
			fn (Owner $owner): OwnerDto => OwnerDto::fromEntity($owner),
			iterator_to_array($this->ownerProvider->getOwners()),
		);

		return new JsonResponse($owners);
	}

	/** @param array{ownerId: string} $args */
	public function actionGetOwner(ServerRequestInterface $request, array $args): ResponseInterface
	{
		$ownerId = (int) $args['ownerId'];
		if ($ownerId < 1) {
			return new NotFoundResponse('Owner id is required.');
		}

		$owner = $this->ownerProvider->getOwner(ownerId: $ownerId);
		if ($owner === null) {
			return new NotFoundResponse('Owner with id "' . $ownerId . '" was not found.');
		}

		return new JsonResponse(OwnerDto::fromEntity($owner));
	}

	public function actionCreateOwner(ServerRequestInterface $request): ResponseInterface
	{
		/** @var array{firstName: string, lastName: string} $requestBody */
		$requestBody = json_decode($request->getBody()->getContents(), assoc: true);

		return new JsonResponse(OwnerDto::fromEntity($this->ownerProvider->createOwner(
			firstName: $requestBody['firstName'],
			lastName: $requestBody['lastName'],
		)));
	}

	/** @param array{ownerId: string} $args */
	public function actionUpdateOwner(ServerRequestInterface $request, array $args): ResponseInterface
	{
		$ownerId = (int) $args['ownerId'];
		if ($ownerId < 1) {
			return new NotFoundResponse('Owner id is required.');
		}

		$owner = $this->ownerProvider->getOwner(ownerId: $ownerId);
		if ($owner === null) {
			return new NotFoundResponse('Owner with id "' . $ownerId . '" was not found.');
		}

		/** @var array{firstName: string, lastName: string} $requestBody */
		$requestBody = json_decode($request->getBody()->getContents(), assoc: true);

		return new JsonResponse(OwnerDto::fromEntity($this->ownerProvider->updateOwner(
			$owner,
			firstName: $requestBody['firstName'],
			lastName: $requestBody['lastName'],
		)));
	}

	/** @param array{ownerId: string} $args */
	public function actionDeleteOwner(ServerRequestInterface $request, array $args): ResponseInterface
	{
		$ownerId = (int) $args['ownerId'];
		if ($ownerId < 1) {
			return new NotFoundResponse('Owner id is required.');
		}

		$owner = $this->ownerProvider->getOwner(ownerId: $ownerId);
		if ($owner === null) {
			return new NotFoundResponse('Owner with id "' . $ownerId . '" was not found.');
		}

		$this->ownerProvider->deleteOwner($owner);

		return new OkResponse();
	}
}
