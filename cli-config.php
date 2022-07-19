<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

require __DIR__ . '/vendor/autoload.php';
$em = require_once "public/bootstrap.php";

$commands = [
    // eigene Commands hinzufügen möglich
];

ConsoleRunner::run(
    new SingleManagerProvider($em),
    $commands
);