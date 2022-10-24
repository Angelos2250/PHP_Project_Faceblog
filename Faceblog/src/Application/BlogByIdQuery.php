<?php

namespace Application;
use Application\Entities\Blogs;
class BlogByIdQuery {
    public function __construct(
        private \Application\Interfaces\BlogsRepository $blogsRepository
    )
    { }

    public function execute(string $blogsId) : Blogs {
        $blogs = $this->blogsRepository->getBlogById($blogsId);
        $res = null;
        if (isset($blogs)) {
            $res = new Blogs(
                $blogs->getBlogsId(),
                $blogs->getUsers(),
                $blogs->getTitle(),
                $blogs->getText(),
                $blogs->getDate(),
            );
        }
        return $res;
    }

}