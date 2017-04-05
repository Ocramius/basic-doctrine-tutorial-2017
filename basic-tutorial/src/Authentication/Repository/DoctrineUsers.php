<?php

namespace Authentication\Repository;

use Authentication\Entity\User;
use Authentication\Repository\Exception\UserNotFound;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

final class DoctrineUsers implements Users
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var ObjectRepository
     */
    private $users;

    public function __construct(
        ObjectManager $objectManager,
        ObjectRepository $users
    ) {
        $this->objectManager = $objectManager;
        $this->users         = $users;
    }

    public function has(string $emailAddress) : bool
    {
        try {
            $this->get($emailAddress);

            return true;
        } catch (UserNotFound $ignored) {
            return false;
        }
    }

    public function get(string $emailAddress) : User
    {
        $user = $this->users->find($emailAddress);

        if (! $user instanceof User) {
            throw UserNotFound::fromEmailAddress($emailAddress);
        }

        return $user;
    }

    public function store(User $user) : void
    {
        $this->objectManager->persist($user);
        $this->objectManager->flush();
    }
}