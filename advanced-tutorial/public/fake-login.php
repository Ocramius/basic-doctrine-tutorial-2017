<?php

use Authentication\Entity\User;

session_start();

/* @var $entityManager \Doctrine\ORM\EntityManagerInterface */
$entityManager = require __DIR__ . '/../bootstrap.php';

/* @var $user User */
$user = $entityManager->find(User::class, $_GET['userId']);

$_SESSION['userId'] = (string) $user->getId();
