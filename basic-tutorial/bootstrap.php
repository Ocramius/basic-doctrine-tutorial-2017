<?php

use Authentication\UserEmailType;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\DBAL\Driver\PDOSqlite\Driver;
use Doctrine\ORM\Cache\DefaultCacheFactory;
use Doctrine\ORM\Cache\Logging\StatisticsCacheLogger;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Doctrine\ORM\Proxy\ProxyFactory;

require_once __DIR__ . '/vendor/autoload.php';

$cache         = new FilesystemCache(__DIR__ . '/data/l2-cache');
$configuration = new Configuration();

// We use annotations for loading the entities in our system
$configuration->setMetadataDriverImpl(new XmlDriver(__DIR__ . '/mapping'));

// This is needed for Doctrine to generate files required for lazy-loading
$configuration->setProxyDir(sys_get_temp_dir());
$configuration->setProxyNamespace('ProxyExample');

// We are telling Doctrine to always generate files required for lazy-loading. This is a slow operation,
// and shouldn't be done in a production environment.
$configuration->setAutoGenerateProxyClasses(ProxyFactory::AUTOGENERATE_ALWAYS);

$configuration->setSecondLevelCacheEnabled();

$l2Config = $configuration
    ->getSecondLevelCacheConfiguration();

$l2Config->setCacheFactory(new DefaultCacheFactory(
    new \Doctrine\ORM\Cache\RegionsConfiguration(),
    $cache
));

$l2CacheLogger = new StatisticsCacheLogger();

$l2Config->setCacheLogger($l2CacheLogger);

register_shutdown_function(function () use ($l2CacheLogger) {
    var_dump([
        'hit' => $l2CacheLogger->getHitCount(),
        'miss' => $l2CacheLogger->getMissCount(),
        'put' => $l2CacheLogger->getPutCount(),
    ]);
});

Doctrine\DBAL\Types\Type::addType(UserEmailType::NAME, UserEmailType::class);

// Finally creating the EntityManager: our entry point for the ORM
return EntityManager::create(
    [
        'driverClass' => Driver::class,
        'path'        => __DIR__ . '/data/test-db.sqlite',
    ],
    $configuration
);
