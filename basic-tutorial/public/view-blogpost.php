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
    'comments' => array_map(
        function (\Blog\Entity\BlogPost\Comment $comment) : array {
            return [
                'author' => $comment->getAuthor()->id(),
                'text' => $comment->getText(),
            ];
        },
        $blogPost->getComments()
    )
]);

?>
<form action="blogpost-comment.php?id=<?= $_GET['id'] ?>" method="post">
    <textarea name="text" required="required"></textarea>
    <input type="submit"/>
</form>


<?php

var_dump([
    'hit' => $cacheLogger->getHitCount(),
    'miss' => $cacheLogger->getMissCount(),
    'put' => $cacheLogger->getPutCount(),
]);
