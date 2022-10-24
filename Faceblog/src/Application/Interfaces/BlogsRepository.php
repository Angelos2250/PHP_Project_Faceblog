<?php

namespace Application\Interfaces;
use Application\Entities\Blogs;
interface BlogsRepository {
    public function getBlogsForUser($usersId): array;
    public function getBlogById($blogsId): Blogs;
    public function getBlogsCount(): ?int;
    public function getBlogs24Count(): ?int;
    public function getLatestBlog(): ?string;
    public function insertBlog(int $usersId, string $title, string $text, string $date): int;
    public function deleteBlog($blogsId): int;
}