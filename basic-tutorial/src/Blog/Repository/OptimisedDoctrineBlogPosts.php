<?php

namespace Blog\Repository;

use Authentication\Entity\User;
use Authentication\Repository\Exception\UserNotFound;
use Blog\Entity\BlogPost;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

final class OptimisedDoctrineBlogPosts implements BlogPosts
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    public function get(string $id) : BlogPost
    {
        $query = <<<'DQL'
SELECT
    b,
    a,
    c
FROM
    Blog\Entity\BlogPost b
LEFT JOIN
    b.author a
LEFT JOIN
    b.comments c
WHERE b.id = :id
DQL;

        $blogPost = $this->entityManager->createQuery($query)->setParameter('id', $id)->getOneOrNullResult();

        if (! $blogPost instanceof BlogPost) {
            throw new \UnexpectedValueException(sprintf('Could not find blogpost "%s"', $id));
        }

        return $blogPost;
    }

    public function store(BlogPost $blogPost) : void
    {
        $this->entityManager->persist($blogPost);
        $this->entityManager->flush();
    }
}