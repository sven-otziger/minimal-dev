<?php

namespace Handler;

use Repository\PermissionRepository;

class PermissionHandler
{
    private static ?PermissionHandler $permissionHandler = null;
    private PermissionRepository $permissionRepo;

    private function __construct()
    {
        $this->permissionRepo = new PermissionRepository();
    }

    public static function getPermissionHandler(): PermissionHandler
    {
        if (self::$permissionHandler === null) {
            self::$permissionHandler = new PermissionHandler();
        }
        return self::$permissionHandler;
    }

    public function getPermissions(int $userId): ?\stdClass
    {
        return $this->permissionRepo->getPermissions($userId);
    }


}