<?php

namespace Authentication;

final class ClearTextPassword
{
    /**
     * @var string
     */
    private $password;

    private function __construct()
    {
    }

    public static function fromString(string $password) : self
    {
        $instance = new self();

        if (! (
            preg_match('/[A-Z]+/', $password)
            && preg_match('/[a-z]+/', $password)
            && preg_match('/\d+/', $password)
        )) {
            throw new \InvalidArgumentException('Password must contain ucletter, lcletter, number');
        }

        $instance->password = $password;

        return $instance;
    }

    public function toString() : string
    {
        return $this->password;
    }
}
