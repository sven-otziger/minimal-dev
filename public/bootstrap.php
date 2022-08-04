<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Entity\Product;

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(dirname(__DIR__) . "/src"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

// or if you prefer yaml or XML
// $config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
// $config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// database configuration parameters
$connectionParams = [
	'dbname' => $_ENV['MARIADB_DATABASE'],
	'user' => $_ENV['MARIADB_USER'],
	'password' => $_ENV['MARIADB_PASSWORD'],
	'host' => 'mariadb',
	'driver' => 'pdo_mysql',
];
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);


// obtaining the entity manager
return EntityManager::create($conn, $config);
