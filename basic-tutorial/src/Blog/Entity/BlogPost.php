<?php

namespace Blog\Entity;

use Authentication\Entity\User;

class BlogPost
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $text;

    /**
     * @var User
     */
    private $author;

    private function __construct(
        string $id,
        string $title,
        string $text,
        User $author
    )
    {
        $this->id     = $id;
        $this->title  = $title;
        $this->text   = $text;
        $this->author = $author;
    }

    public static function publish(
        string $id,
        string $title,
        string $text,
        User $author
    ) : self
    {
        return new self($id, $title, $text, $author);
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function getText() : string
    {
        return $this->text;
    }

    public function getAuthor() : User
    {
        return $this->author;
    }
}
