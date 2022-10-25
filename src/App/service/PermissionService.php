<?php

namespace Service;

use Repository\PermissionRepository;

class PermissionService
{
    private static ?PermissionService $permissionService = null;
    private PermissionRepository $permissionRepo;

    private function __construct()
    {
        $this->permissionRepo = new PermissionRepository();
    }

    public static function getPermissionService(): PermissionService
    {
        if (self::$permissionService === null) {
            self::$permissionService = new PermissionService();
        }
        return self::$permissionService;
    }

    public function getPermissions(int $userId): ?\stdClass
    {
        return $this->permissionRepo->getPermissions($userId);
    }


}