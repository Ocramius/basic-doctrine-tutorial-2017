<?php

namespace Authentication\Entity\Exception;

class UserAlreadyRegistered extends \UnexpectedValueException
{
    public static function fromEmailAddress(string $address) : self
    {
        return new self(sprintf('User by email address "%s" already exists', $address));
    }
}
