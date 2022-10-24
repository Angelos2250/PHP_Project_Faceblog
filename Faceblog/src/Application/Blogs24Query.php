<?php

namespace Application;
class Blogs24Query {
    public function __construct(
        private Interfaces\BlogsRepository $blogsRepository
    ) {
    }

    public function execute(): int {
        return $this->blogsRepository->getBlogs24Count();
    }
}