<?php

namespace Application;
class LatestBlogDateQuery {
    public function __construct(
        private Interfaces\BlogsRepository $blogsRepository
    ) {
    }

    public function execute(): ?string {
        $res = $this->blogsRepository->getLatestBlog();
        if (isset($res)){
            return $res;
        }
        return "No blogs yet";
    }
}