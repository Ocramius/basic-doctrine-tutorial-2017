<?php

namespace Authentication;

final class UserEmail
{
    /**
     * @var string
     */
    private $email;

    private function __construct()
    {
    }

    public static function fromString(string $email) : self
    {
        if (! filter_var($email, \FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(sprintf(
                'Provided email "%s" is not well formed',
                $email
            ));
        }

        $instance = new self();

        $instance->email = $email;

        return $instance;
    }

    public function toString() : string
    {
        return $this->email;
    }

    public function __toString() : string
    {
        return $this->email;
    }
}
