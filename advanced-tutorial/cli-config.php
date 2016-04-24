<?php

use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Helper\HelperSet;

/* @var $entityManager \Doctrine\ORM\EntityManagerInterface */
$entityManager = require __DIR__ . '/bootstrap.php';

$connectionHelper = new ConnectionHelper($entityManager->getConnection());

return new HelperSet([
    'em'         => new EntityManagerHelper($entityManager),
    'db'         => $connectionHelper,
    'connection' => $connectionHelper,
]);
