<?php

namespace Blog\Repository;

use Authentication\Entity\User;
use Authentication\Repository\Exception\UserNotFound;
use Blog\Entity\BlogPost;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

final class DoctrineBlogPosts implements BlogPosts
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var ObjectRepository
     */
    private $blogPosts;

    public function __construct(
        ObjectManager $objectManager,
        ObjectRepository $users
    ) {
        $this->objectManager = $objectManager;
        $this->blogPosts     = $users;
    }

    public function get(string $id) : BlogPost
    {

        $blogPost = $this->blogPosts->find($id);

        if (! $blogPost instanceof BlogPost) {
            throw new \UnexpectedValueException(sprintf('Could not find blogpost "%s"', $id));
        }

        return $blogPost;
    }

    public function store(BlogPost $blogPost) : void
    {
        $this->objectManager->persist($blogPost);
        $this->objectManager->flush();
    }
}