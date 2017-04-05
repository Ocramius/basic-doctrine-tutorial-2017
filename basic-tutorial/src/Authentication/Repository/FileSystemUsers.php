<?php

namespace Authentication\Repository;

use Authentication\Entity\User;
use Authentication\Repository\Exception\UserNotFound;

final class FileSystemUsers implements Users
{
    /**
     * @var string
     */
    private $storage;

    public function __construct(string $storage)
    {
        $this->storage = $storage;
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
        if (! is_file($this->storage . '/' . $emailAddress)) {
            throw UserNotFound::fromEmailAddress($emailAddress);
        }

        return unserialize(file_get_contents($this->storage . '/' . $emailAddress));
    }

    public function store(User $user) : void
    {
        file_put_contents($this->storage . '/' . $user->id(), serialize($user));
    }
}