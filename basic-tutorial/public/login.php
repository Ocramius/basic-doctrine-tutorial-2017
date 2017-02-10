<?php

use Authentication\ClearTextPassword;
use Authentication\Entity\User;
use Authentication\UserEmail;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

/* @var $entityManager ObjectManager */
$entityManager = require __DIR__ . '/../bootstrap.php';

$users = new \Authentication\Repository\DoctrineUsers(
    $entityManager->getRepository(User::class),
    $entityManager
);

$emailAddress = UserEmail::fromString($_POST['emailAddress']);

if (! $users->has($emailAddress)) {
    echo 'Couldn\'t log in';

    return;
}

$user = $users->get($emailAddress);

if (! $user->authenticate(ClearTextPassword::fromString($_POST['password']))) {
    echo 'Couldn\'t log in';

    return;
}

echo 'Everything OK: ' . $user->emailAddress()->toString();
