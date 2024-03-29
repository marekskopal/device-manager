<?php

declare(strict_types=1);

namespace DeviceManager\Middleware\Exception;

use Psr\Http\Message\RequestInterface;

class NotAuthorizedException extends \RuntimeException
{
	public function __construct(string $message, private readonly RequestInterface $request, int $code = 401, ?\Throwable $previous = null,)
	{
		parent::__construct($message, $code, $previous);
	}

	public function getRequest(): RequestInterface
	{
		return $this->request;
	}
}
