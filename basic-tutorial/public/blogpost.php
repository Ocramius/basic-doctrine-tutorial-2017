<?php

require_once __DIR__ . '/../vendor/autoload.php';

/* @var $entityManager \Doctrine\ORM\EntityManager */
$entityManager = require __DIR__ . '/../bootstrap.php';

$blogPosts = new \Blog\Repository\DoctrineBlogPosts(
    $entityManager,
    $entityManager->getRepository(\Blog\Entity\BlogPost::class)
);

$id = uniqid('id', true);

$blogPost = \Blog\Entity\BlogPost::publish(
    $id,
    $_POST['title'],
    $_POST['text'],
    $entityManager->find(\Authentication\Entity\User::class, 'somebody@example.com')
);

$blogPosts->store($blogPost);

echo "OK";