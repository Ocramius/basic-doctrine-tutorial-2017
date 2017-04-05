<?php

namespace Authentication\Entity;

use Authentication\Entity\Exception\UserAlreadyRegistered;
use Authentication\Repository\Users;

class User
{
    /**
     * @var string
     */
    private $emailAddress;

    /**
     * @var string
     */
    private $passwordHash;

    private function __construct(string $emailAddress, string $passwordHash)
    {
        $this->emailAddress = $emailAddress;
        $this->passwordHash = $passwordHash;
    }

    public static function register(
        string $emailAddress,
        string $password,
        callable $hashPassword,
        Users $existingUsers
    ) : self {
        if ($existingUsers->has($emailAddress)) {
            throw UserAlreadyRegistered::fromEmailAddress($emailAddress);
        }

        return new self($emailAddress, $hashPassword($password));
    }

    public function authenticate(string $password, callable $verifyPassword) : bool
    {
        return $verifyPassword($password, $this->passwordHash);
    }

    public function id() : string
    {
        return $this->emailAddress;
    }
}
