<?php

namespace Authentication\Repository;

use Authentication\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

final class DoctrineUsers implements Users
{
    /**
     * @var ObjectRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(
        ObjectRepository $repository,
        ObjectManager $objectManager
    )
    {
        $this->repository    = $repository;
        $this->objectManager = $objectManager;
    }

    public function get(string $emailAddress) : User
    {
        $user = $this->repository->find($emailAddress);

        if (! $user instanceof User) {
            throw new \UnexpectedValueException(sprintf('Could not find user "%s"', $emailAddress));
        }

        return $user;
    }

    public function has(string $emailAddress) : bool
    {
        $user = $this->repository->find($emailAddress);

        return $user instanceof User;
    }

    public function add(User $user)
    {
        $this->objectManager->persist($user);
        $this->objectManager->flush();
    }
}
