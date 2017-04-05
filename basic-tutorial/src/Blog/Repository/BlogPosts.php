<?php

namespace Blog\Repository;

use Blog\Entity\BlogPost;

interface BlogPosts
{
    public function get(string $id) : BlogPost;
    public function store(BlogPost $blogPost) : void;
}