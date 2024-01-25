<?php

declare(strict_types=1);

namespace Migration;

use Cycle\Migrations\Migration;

// phpcs:ignore
class InitDataMigration extends Migration
{
	protected const DATABASE = 'default';

	public function up(): void
	{
		$this->database()->insert('users')->values([
			['id' => 1, 'email' => 'admin@example.com', 'password' => '$2y$10$hIms8XZBw045eVf9EjzE7O.Ru7iCQ8iXY5aU8ktmzHlyw4l7DO69O', 'name' => 'Admin'],
		])->run();
	}

	public function down(): void
	{
		$this->database()->query('TRUNCATE ?', ['users']);
	}
}
