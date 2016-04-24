<?php

namespace Authentication\Entity;

use Ramsey\Uuid\Uuid;

class User
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    private $id;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    /**
     * @return \Ramsey\Uuid\UuidInterface
     */
    public function getId()
    {
        return $this->id;
    }
}
