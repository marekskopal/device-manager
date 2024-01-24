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
			['id' => 1, 'email' => 'admin@example.com', 'password' => '$2y$10$Gv6vVjtQsz2n/1zk.wbyKOOON7ThrnpzJ0U7xJAUNHSE.4dJSyvSS', 'name' => 'Admin'],
		])->run();
	}

	public function down(): void
	{
		$this->database()->query('TRUNCATE ?', ['users']);
	}
}
