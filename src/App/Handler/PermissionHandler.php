<?php

namespace Handler;

class PermissionHandler
{
    private static ?PermissionHandler $permissionHandler = null;

    private function __construct()
    {

    }

    public static function getPermissionHandler(): PermissionHandler
    {
        if (self::$permissionHandler === null) {
            self::$permissionHandler = new PermissionHandler();
        }
        return self::$permissionHandler;
    }



}