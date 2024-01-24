<?php

declare(strict_types=1);

namespace DeviceManager\Route;

use DeviceManager\Controller\AuthenticationController;
use DeviceManager\Controller\DeviceController;
use DeviceManager\Controller\OwnerController;

enum Routes: string
{
	case Health = '/api/health';

	case AuthenticationLogin = '/api/authentication/login';
	case AuthenticationRefreshToken = '/api/authentication/refresh-token';

	case Devices = '/api/device';
	case Device = '/api/device/{deviceId:number}';

	case Owners = '/api/owner';
	case Owner = '/api/owner/{ownerId:number}';

	public static function getRouteList(): RouteList
	{
		$routeList = new RouteList();

		$routeList->get(self::Health->value, fn (): array => ['status' => 200, 'message' => 'OK']);

		$routeList->post(self::AuthenticationLogin->value, [AuthenticationController::class, 'actionPostLogin']);
		$routeList->post(self::AuthenticationRefreshToken->value, [AuthenticationController::class, 'actionPostRefreshToken']);

		$routeList->get(self::Devices->value, [DeviceController::class, 'actionGetDevices']);
		$routeList->get(self::Device->value, [DeviceController::class, 'actionGetDevice']);
		$routeList->post(self::Devices->value, [DeviceController::class, 'actionCreateDevice']);
		$routeList->put(self::Device->value, [DeviceController::class, 'actionUpdateDevice']);
		$routeList->delete(self::Device->value, [DeviceController::class, 'actionDeleteDevice']);

		$routeList->get(self::Owners->value, [OwnerController::class, 'actionGetOwners']);
		$routeList->get(self::Owner->value, [OwnerController::class, 'actionGetOwner']);
		$routeList->post(self::Owners->value, [OwnerController::class, 'actionCreateOwner']);
		$routeList->put(self::Owner->value, [OwnerController::class, 'actionUpdateOwner']);
		$routeList->delete(self::Owner->value, [OwnerController::class, 'actionDeleteOwner']);

		return $routeList;
	}
}
