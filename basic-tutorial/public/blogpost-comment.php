<?php

require_once __DIR__ . '/../vendor/autoload.php';

/* @var $entityManager \Doctrine\ORM\EntityManager */
$entityManager = require __DIR__ . '/../bootstrap.php';

$blogPosts = new \Blog\Repository\DoctrineBlogPosts(
    $entityManager,
    $entityManager->getRepository(\Blog\Entity\BlogPost::class)
);

$blogPost = $blogPosts->get($_GET['id']);

$blogPost->publishComment(
    $_POST['text'],
    $entityManager->find(\Authentication\Entity\User::class, 'somebody@example.com')
);

$blogPosts->store($blogPost); // comment was not persisted?

header('Location: view-blogpost.php?id=' . $_GET['id']);
