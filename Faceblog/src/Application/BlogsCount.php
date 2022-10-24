<?php

namespace Application;
class BlogsCount {
    public function __construct(
        private Interfaces\BlogsRepository $blogsRepository
    ) {
    }

    public function execute(): int {
        return $this->blogsRepository->getBlogsCount();
    }
}