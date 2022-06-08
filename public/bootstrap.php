<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Entity\Product;

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "../src"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
// or if you prefer yaml or XML
// $config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
// $config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// database configuration parameters
$connectionParams = [
	'dbname' => 'doctrine',
	'user' => 'root',
	'password' => 'root',
	'host' => 'mariadb',
	'driver' => 'pdo_mysql',
];
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);


// obtaining the entity manager
$em = EntityManager::create($conn, $config);


// create
$p1 = new Product();
$em->persist($p1);

// find
echo Product::class;
$productRepo = $em->getRepository(Product::class);
dump($productRepo);
echo "\n\n" . get_class($productRepo);
//$products = $productRepo->findAll();


dump($em);
