<?php

use Authentication\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

/* @var $entityManager ObjectManager */
$entityManager = require __DIR__ . '/../bootstrap.php';

$users = new \Authentication\Repository\DoctrineUsers(
    $entityManager->getRepository(User::class),
    $entityManager
);

$emailAddress = $_POST['emailAddress'];
$clearTextPassword = $_POST['password'];

if (! $users->has($emailAddress)) {
    echo 'Couldn\'t log in';

    return;
}

$user = $users->get($emailAddress);

if (! $user->authenticate($clearTextPassword)) {
    echo 'Couldn\'t log in';

    return;
}

echo 'Everything OK';
