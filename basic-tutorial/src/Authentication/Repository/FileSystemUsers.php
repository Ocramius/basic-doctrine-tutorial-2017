<?php

namespace Authentication\Repository;

use Authentication\Entity\User;
use Authentication\UserEmail;

final class FileSystemUsers implements Users
{
    public function get(UserEmail $emailAddress) : User
    {
        $user = $this->fetchFromDb($emailAddress);

        if (! $user instanceof User) {
            throw new \UnexpectedValueException(sprintf('Could not find user "%s"', $emailAddress));
        }

        return $user;
    }

    public function has(UserEmail $emailAddress) : bool
    {
        $user = $this->fetchFromDb($emailAddress);

        return $user instanceof User;
    }

    public function add(User $user)
    {
        file_put_contents($this->filePath($user->emailAddress()), serialize($user));
    }

    private function fetchFromDb(UserEmail $emailAddress)
    {
        $path = $this->filePath($emailAddress);

        if (! file_exists($path)) {
            return null;
        }

        return unserialize(file_get_contents($path));
    }

    private function filePath(UserEmail $emailAddress) : string
    {
        return __DIR__ . '/../../../data/user-' . $emailAddress->toString();
    }
}