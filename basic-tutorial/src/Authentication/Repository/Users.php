<?php

namespace Authentication\Repository;

use Authentication\Entity\User;
use Authentication\UserEmail;

interface Users
{
    public function get(UserEmail $emailAddress) : User;
    public function has(UserEmail $emailAddress) : bool;
    public function add(User $user);
}