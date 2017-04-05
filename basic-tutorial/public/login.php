<?php

require_once __DIR__ . '/../vendor/autoload.php';

/* @var $entityManager \Doctrine\ORM\EntityManager */
$entityManager = require __DIR__ . '/../bootstrap.php';

$users = new \Authentication\Repository\DoctrineUsers(
    $entityManager,
    $entityManager->getRepository(\Authentication\Entity\User::class)
);

try {
    $user = $users->get($_POST['emailAddress']);
} catch (\Authentication\Repository\Exception\UserNotFound $notFound) {
    echo "KO";

    return;
}

if ($user->authenticate(
    $_POST['password'],
    function (string $password, string $hash) : bool {
        return password_verify($password, $hash);
    }
)) {
    echo "OK";

    return;
}

echo "KO";

// 1. fetch user by email
// 2. compare user password hash against given password
// 3. is the user banned? (optional)
// 4. log login (optional)
// 5. store user identifier into the session

// discuss: should the fetching by password happen at database level?
//          Should it happen inside the entity?
//          Or in a service?
