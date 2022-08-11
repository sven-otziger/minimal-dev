<?php

namespace Repository;

use Service\DatabaseService;

abstract class Repository
{
    protected DatabaseService $dbService;

    public function __construct()
    {
        $this->dbService = DatabaseService::getInstance();
    }
}