<?php

namespace Authentication\Repository\Exception;

class UserNotFound extends \UnexpectedValueException
{
    public static function fromEmailAddress(string $address) : self
    {
        return new self(sprintf('Could not find user by email address "%s"', $address));
    }
}
