<?php

namespace App\Repository;

use App\ActiveRecord\Post;

class PostRepository
{
    public function findOne(int $id): ?Post
    {
        return Post::findOne($id);
    }
}
