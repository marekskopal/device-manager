<?php

declare(strict_types=1);

namespace DeviceManager\App;

use Cycle\ORM\ORM;
use DeviceManager\Middleware\AuthorizationMiddleware;
use DeviceManager\Model\Entity\Device;
use DeviceManager\Model\Entity\Owner;
use DeviceManager\Model\Entity\User;
use DeviceManager\Model\Repository\DeviceRepository;
use DeviceManager\Model\Repository\OwnerRepository;
use DeviceManager\Model\Repository\UserRepository;
use DeviceManager\Route\Routes;
use DeviceManager\Route\Strategy\JsonStrategy;
use DeviceManager\Service\Dbal\DbContext;
use DeviceManager\Service\Logger\Logger;
use Http\Discovery\Psr17FactoryDiscovery;
use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Route\Router;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

final class ApplicationFactory
{
	public static function create(): Application
	{
		$dbContext = self::initializeDbContext();
		$container = self::initializeContainer($dbContext);
		$requestHandler = self::initializeRequestHandler($container);

		return new Application($container, $requestHandler, $dbContext);
	}

	private static function initializeContainer(DbContext $dbContext): ContainerInterface
	{
		$container = new Container();
		$container->defaultToShared();
		$container->delegate((new ReflectionContainer(true)));

		$container->add(LoggerInterface::class, fn () => Logger::initLogger(__DIR__ . '/../../log'));

		$container->add(
			ResponseFactoryInterface::class,
			fn (): ResponseFactoryInterface => Psr17FactoryDiscovery::findResponseFactory()
		);

		$container->add(ORM::class, $dbContext->getOrm());

		$orm = $container->get(ORM::class);
		assert($orm instanceof ORM);

		$container->add(DeviceRepository::class, fn () => $orm->getRepository(Device::class));
		$container->add(OwnerRepository::class, fn () => $orm->getRepository(Owner::class));
		$container->add(UserRepository::class, fn () => $orm->getRepository(User::class));

		return $container;
	}

	private static function initializeRequestHandler(ContainerInterface $container): RequestHandlerInterface
	{
		$strategy = $container->get(JsonStrategy::class);
		assert($strategy instanceof JsonStrategy);
		$strategy->setContainer($container);

		$router = new Router();
		$router->setStrategy($strategy);

		$authorizationMiddleware = $container->get(AuthorizationMiddleware::class);
		assert($authorizationMiddleware instanceof AuthorizationMiddleware);
		$router->middleware($authorizationMiddleware);

		$routeList = Routes::getRouteList();
		$routeList->setRouteListToRouter($router);

		return $router;
	}

	private static function initializeDbContext(): DbContext
	{
		$host = (string) getenv('MYSQL_HOST');
		$database = (string) getenv('MYSQL_DATABASE');
		/** @var non-empty-string $user */
		$user = (string) getenv('MYSQL_USER');
		/** @var non-empty-string $password */
		$password = (string) getenv('MYSQL_PASSWORD');

		return new DbContext(dsn: 'mysql:host=' . $host . ';dbname=' . $database, user: $user, password: $password);
	}
}
