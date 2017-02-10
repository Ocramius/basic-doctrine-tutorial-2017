<?php

use Authentication\Entity\User;
use Authentication\Repository\FileSystemUsers;
use Doctrine\Common\Persistence\ObjectManager;

require __DIR__ . '/../vendor/autoload.php';

/* @var $entityManager ObjectManager */
$entityManager = require __DIR__ . '/../bootstrap.php';

$emailAddress = $_POST['emailAddress'];
$clearTextPassword = $_POST['password'];

$users = new \Authentication\Repository\DoctrineUsers(
    $entityManager->getRepository(User::class),
    $entityManager
);

try {
    $registeredUser = User::register(
        $users,
        $emailAddress,
        $clearTextPassword
    );
    $users->add($registeredUser);
} catch (\LogicException $alreadyExistingUser) {
    echo sprintf('User "%s" is already registered', htmlentities($emailAddress));

    return;
}

echo 'Correctly registered!';
