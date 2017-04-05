<?php

require_once __DIR__ . '/../vendor/autoload.php';

$users = new \Authentication\Repository\FileSystemUsers(__DIR__ . '/../data');

$user = \Authentication\Entity\User::register(
    $_POST['emailAddress'],
    $_POST['password'],
    function (string $password) : string {
        return \password_hash($password, \PASSWORD_DEFAULT);
    },
    $users
);

$users->store($user);

echo "OK";

// registering a new user:

// 1. check if a user with the same email address exists
// 2. if not, create a user
// 3. hash the password
// 4. send the email to confirm activation (we will just display it)
// 5. save the user

// Tip: discuss - email or saving? Chicken-egg problem
