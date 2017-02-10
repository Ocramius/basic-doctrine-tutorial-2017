<?php

namespace Authentication\Entity;

use Authentication\ClearTextPassword;
use Authentication\Repository\Users;
use Authentication\UserEmail;

class User
{
    /**
     * @var UserEmail
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
     * @param UserEmail $emailAddress
     * @param ClearTextPassword $clearTextPassword
     *
     * @return User
     * @throws \LogicException
     */
    public static function register(
        Users $existingUsers,
        UserEmail $emailAddress,
        ClearTextPassword $clearTextPassword
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
            $clearTextPassword->toString(),
            \PASSWORD_DEFAULT
        );

        return $user;
    }

    public function authenticate(ClearTextPassword $clearTextPassword) : bool
    {
        return \password_verify($clearTextPassword->toString(), $this->passwordHash);
    }

    public function emailAddress() : UserEmail
    {
        return $this->emailAddress;
    }
}
