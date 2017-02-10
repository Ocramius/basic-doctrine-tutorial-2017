<?php

namespace Authentication\Entity;

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

    private function __construct()
    {
    }

    /**
     * @param Users  $existingUsers
     * @param string $emailAddress
     *
     * @return User
     * @throws \LogicException
     */
    public static function register(
        Users $existingUsers,
        string $emailAddress,
        string $clearTextPassword
    ) : self
    {
        if ($existingUsers->has($emailAddress)) {
            throw new \LogicException(sprintf(
                'User "%s" already exists',
                $emailAddress
            ));
        }

        $user = new self();

        $user->emailAddress = $emailAddress;
        $user->passwordHash = password_hash(
            $clearTextPassword,
            \PASSWORD_DEFAULT
        );

        return $user;
    }

    public function authenticate(string $clearTextPassword) : bool
    {
        return \password_verify($clearTextPassword, $this->passwordHash);
    }

    public function emailAddress() : string
    {
        return $this->emailAddress;
    }
}
