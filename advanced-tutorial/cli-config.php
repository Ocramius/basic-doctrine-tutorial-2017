<?php

use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Helper\HelperSet;

/* @var $entityManager \Doctrine\ORM\EntityManagerInterface */
$entityManager = require __DIR__ . '/bootstrap.php';

return new HelperSet([
    'em'         => new EntityManagerHelper($entityManager),
    'connection' => new ConnectionHelper($entityManager->getConnection()),
]);
