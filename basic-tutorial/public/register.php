<?php

use Authentication\Entity\User;
use Authentication\Repository\FileSystemUsers;

require __DIR__ . '/../vendor/autoload.php';

$emailAddress = $_POST['emailAddress'];
$clearTextPassword = $_POST['password'];

$users = new FileSystemUsers();

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
