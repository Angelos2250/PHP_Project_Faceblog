<?php


namespace Application;

class DeleteBlogCommand {
    public function __construct(
        private Interfaces\BlogsRepository $blogsRepository
    ) {
    }

    public function execute(int $bid): bool {
        return $this->blogsRepository->deleteBlog($bid);
    }
}
