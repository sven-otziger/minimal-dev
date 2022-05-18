<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddUserInformation extends AbstractMigration
{
	/**
	 * Change Method.
	 *
	 * Write your reversible migrations using this method.
	 *
	 * More information on writing migrations is available here:
	 * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
	 *
	 * Remember to call "create()" or "update()" and NOT "save()" when working
	 * with the Table class.
	 */
	public function change(): void
	{
		$this->table('user')
			->addColumn('street', 'string', ['limit' => 127])
			->addColumn('house-number', 'string', ['limit' => 7])
			->addColumn('zip-code', 'string', ['limit' => 15])
			->addColumn('city', 'string', ['limit' => 63])
			->update();
	}
}
