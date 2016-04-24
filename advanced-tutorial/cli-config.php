<?php

use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Helper\HelperSet;

return new HelperSet([
    'em' => new EntityManagerHelper(require __DIR__ . '/bootstrap.php')
]);
