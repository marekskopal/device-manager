<?php

declare(strict_types=1);

namespace Migration;

use Cycle\Migrations\Migration;

// phpcs:ignore
class InitMigration extends Migration
{
	protected const DATABASE = 'default';

	public function up(): void
	{
		$this->table('users')
			->addColumn('id', 'primary', ['nullable' => false, 'default' => null, 'size' => 11])
			->addColumn('email', 'string', ['nullable' => false, 'default' => null, 'size' => 255])
			->addColumn('password', 'string', ['nullable' => false, 'default' => null, 'size' => 255])
			->addColumn('name', 'string', ['nullable' => false, 'default' => null, 'size' => 255])
			->addIndex(['email'], ['name' => 'users_index_email', 'unique' => true])
			->setPrimaryKeys(['id'])
			->create();

		$this->table('owners')
			->addColumn('id', 'primary', ['nullable' => false, 'default' => null, 'size' => 11])
			->addColumn('first_name', 'string', ['nullable' => false, 'default' => null, 'size' => 255])
			->addColumn('last_name', 'string', ['nullable' => false, 'default' => null, 'size' => 255])
			->setPrimaryKeys(['id'])
			->create();

		$this->table('devices')
			->addColumn('id', 'primary', ['nullable' => false, 'default' => null, 'size' => 11])
			->addColumn('hostname', 'string', ['nullable' => false, 'default' => null, 'size' => 255])
			->addColumn('type', 'enum', ['nullable' => false, 'default' => null, 'values' => ['pc', 'laptop', 'mobile']])
			->addColumn('os', 'enum', ['nullable' => false, 'default' => null, 'values' => ['windows', 'linux', 'macos', 'ios', 'android']])
			->addColumn('owner_id', 'integer', ['nullable' => false, 'default' => null, 'size' => 11])
			->addIndex(['owner_id'], ['name' => 'devices_index_owner_id', 'unique' => false])
			->addForeignKey(['owner_id'], 'owners', ['id'], [
				'name' => 'devices_foreign_owner_id',
				'delete' => 'CASCADE',
				'update' => 'CASCADE',
				'indexCreate' => true,
			])
			->setPrimaryKeys(['id'])
			->create();
	}

	public function down(): void
	{
		$this->table('devices')->drop();
		$this->table('owners')->drop();
		$this->table('users')->drop();
	}
}
