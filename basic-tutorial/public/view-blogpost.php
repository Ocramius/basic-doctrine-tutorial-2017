<?php

require_once __DIR__ . '/../vendor/autoload.php';

/* @var $entityManager \Doctrine\ORM\EntityManager */
$entityManager = require __DIR__ . '/../bootstrap.php';

$blogPosts = new \Blog\Repository\DoctrineBlogPosts(
    $entityManager,
    $entityManager->getRepository(\Blog\Entity\BlogPost::class)
);

$blogPost = $blogPosts->get($_GET['id']);

var_dump([
    'title' => $blogPost->getTitle(),
    'text' => $blogPost->getText(),
    'author' => $blogPost->getAuthor()->id(),
]);
