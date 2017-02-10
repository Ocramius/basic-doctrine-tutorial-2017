<?php

use Authentication\ClearTextPassword;
use Authentication\Entity\User;
use Authentication\Repository\DoctrineUsers;
use Authentication\Repository\FileSystemUsers;
use Authentication\UserEmail;
use Doctrine\Common\Persistence\ObjectManager;

require __DIR__ . '/../vendor/autoload.php';

/* @var $entityManager ObjectManager */
$entityManager = require __DIR__ . '/../bootstrap.php';

$emailAddress = UserEmail::fromString($_POST['emailAddress']);

$users = new DoctrineUsers(
    $entityManager->getRepository(User::class),
    $entityManager
);

try {
    $registeredUser = User::register(
        $users,
        $emailAddress,
        ClearTextPassword::fromString($_POST['password'])
    );
    $users->add($registeredUser);
} catch (\LogicException $alreadyExistingUser) {
    echo sprintf('User "%s" is already registered', htmlentities($emailAddress));

    return;
}

echo 'Correctly registered!';
