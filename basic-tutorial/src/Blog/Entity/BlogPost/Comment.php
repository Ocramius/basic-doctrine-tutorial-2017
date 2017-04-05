<?php

namespace Blog\Entity\BlogPost;

use Authentication\Entity\User;
use Blog\Entity\BlogPost;

class Comment
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var User
     */
    private $author;

    /**
     * @var BlogPost
     */
    private $blogPost;

    private function __construct(
        string $id,
        string $text,
        User $author,
        BlogPost $blogPost
    )
    {
        $this->id     = $id;
        $this->text   = $text;
        $this->author = $author;
        $this->blogPost = $blogPost;
    }

    public static function create(
        string $text,
        User $author,
        BlogPost $blogPost
    ) : self
    {
        return new self(uniqid('id', true), $text, $author, $blogPost);
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
