<?php

namespace Blog\Entity;

use Authentication\Entity\User;
use Blog\Entity\BlogPost\Comment;
use Doctrine\Common\Collections\ArrayCollection;

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

    /**
     * @var Comment[]
     */
    private $comments;

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
        $this->comments = new ArrayCollection();
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

    public function publishComment(
        string $comment,
        User $author
    ) : void {
        $this->comments->add(Comment::create($comment, $author, $this));
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

    public function getComments() : array
    {
        return $this->comments->toArray();
    }
}
