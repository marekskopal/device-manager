<?php

declare(strict_types=1);

namespace DeviceManager\Command;

use Cycle\Schema\Generator\Migrations\GenerateMigrations;
use DeviceManager\App\ApplicationFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrationGenerateCommand extends Command
{
	protected function configure(): void
	{
		$this->setName('migration:generate');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$application = ApplicationFactory::create();

		$migrator = $application->dbContext->getMigrator();

		$generator = new GenerateMigrations($migrator->getRepository(), $migrator->getConfig());
		$generator->run($application->dbContext->getRegistry());

		return 0;
	}
}
