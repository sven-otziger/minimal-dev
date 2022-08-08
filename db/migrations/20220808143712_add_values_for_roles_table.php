<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddValuesForRolesTable extends AbstractMigration
{
    public function up(): void
    {
        $roleTable = $this->table('role');

        $rows = [
            [
                'description' => 'admin',
                'r_other_users' => true,
                'u_other_users' => true,
                'd_other_users' => true,
                'c_show' => true,
                'r_show' => true,
                'u_show' => true,
                'd_show' => true,
                'c_review' => true,
                'r_review' => true,
                'u_review' => true,
                'd_review' => true,
                'created_by' => 40
            ],
            [
                'description' => 'maintainer',
                'r_other_users' => false,
                'u_other_users' => false,
                'd_other_users' => false,
                'c_show' => true,
                'r_show' => true,
                'u_show' => true,
                'd_show' => true,
                'c_review' => true,
                'r_review' => true,
                'u_review' => true,
                'd_review' => true,
                'created_by' => 40
            ],
            [
                'description' => 'creator',
                'r_other_users' => false,
                'u_other_users' => false,
                'd_other_users' => false,
                'c_show' => true,
                'r_show' => true,
                'u_show' => true,
                'd_show' => true,
                'c_review' => false,
                'r_review' => true,
                'u_review' => false,
                'd_review' => false,
                'created_by' => 40
            ],
            [
                'description' => 'critic',
                'r_other_users' => false,
                'u_other_users' => false,
                'd_other_users' => false,
                'c_show' => false,
                'r_show' => true,
                'u_show' => false,
                'd_show' => false,
                'c_review' => true,
                'r_review' => true,
                'u_review' => true,
                'd_review' => true,
                'created_by' => 40
            ],
            [
                'description' => 'visitor',
                'r_other_users' => false,
                'u_other_users' => false,
                'd_other_users' => false,
                'c_show' => false,
                'r_show' => true,
                'u_show' => false,
                'd_show' => false,
                'c_review' => false,
                'r_review' => true,
                'u_review' => false,
                'd_review' => false,
                'created_by' => 40
            ]
        ];

        $roleTable->insert($rows)->saveData();
    }

    public function down(): void
    {
        $this->execute("
            DELETE FROM role 
            WHERE description = 'admin'
            OR description = 'maintainer'
            OR description = 'creator'
            OR description = 'critic'
            OR description = 'visitor'
       ");
    }
}
