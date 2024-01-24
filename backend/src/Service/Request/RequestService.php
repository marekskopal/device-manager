<?php

declare(strict_types=1);

namespace DeviceManager\Service\Request;

use DeviceManager\Middleware\AuthorizationMiddleware;
use DeviceManager\Model\Entity\User;
use Psr\Http\Message\ServerRequestInterface;

final class RequestService
{
	public function getUser(ServerRequestInterface $request): User
	{
		$user = $request->getAttribute(AuthorizationMiddleware::AttributeUser);
		assert($user instanceof User);
		return $user;
	}
}
