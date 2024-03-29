<?php

declare(strict_types=1);

namespace DeviceManager\Response;

use Laminas\Diactoros\Response\JsonResponse;

class OkResponse extends JsonResponse
{
	/** @param array<string> $headers */
	public function __construct(
		string $data = 'Ok',
		int $status = 200,
		array $headers = [],
		int $encodingOptions = self::DEFAULT_JSON_FLAGS,
	)
	{
		parent::__construct(
			[
				'code' => $status,
				'message' => $data,
			],
			$status,
			$headers,
			$encodingOptions,
		);
	}
}
