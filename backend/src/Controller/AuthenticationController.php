<?php

declare(strict_types=1);

namespace DeviceManager\Controller;

use DeviceManager\Dto\CredentialsDto;
use DeviceManager\Service\Authentication\AuthenticationService;
use DeviceManager\Service\Authentication\Exceptions\AuthenticationException;
use DeviceManager\Service\Request\RequestService;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use function Safe\json_decode;

class AuthenticationController
{
	public function __construct(
		private readonly AuthenticationService $authenticationService,
		private readonly RequestService $requestService,
	) {
	}

	public function actionPostLogin(ServerRequestInterface $request): ResponseInterface
	{
		/** @var array{email: string, password:string} $requestBody*/
		$requestBody = json_decode($request->getBody()->getContents(), assoc: true);

		$credentials = new CredentialsDto($requestBody['email'], $requestBody['password']);

		try {
			return new JsonResponse($this->authenticationService->authenticate($credentials));
		} catch (AuthenticationException) {
			return new JsonResponse('Email or password id invalid.', 401);
		}
	}

	public function actionPostRefreshToken(ServerRequestInterface $request): ResponseInterface
	{
		$user = $this->requestService->getUser($request);

		return new JsonResponse($this->authenticationService->createAuthentication($user));
	}
}
