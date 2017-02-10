<?php

namespace Authentication\Repository;

use Authentication\Entity\User;

interface Users
{
    public function get(string $emailAddress) : User;
    public function has(string $emailAddress) : bool;
    public function add(User $user);
}