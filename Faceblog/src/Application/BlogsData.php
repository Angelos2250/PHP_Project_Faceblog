<?php

namespace Application;

class BlogsData {
    public function __construct(
        private int $blogsId,
        private string $title,
        private string $text,
        private string $date,
        private int $rating,
        private array $likedBy
    )
    {
    }

    /**
     * @return array
     */
    public function getLikedBy(): array
    {
        return $this->likedBy;
    }

    /**
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * @return int
     */
    public function getUsersId(): int
    {
        return $this->usersId;
    }

    /**
     * @return int
     */
    public function getBlogsId(): int
    {
        return $this->blogsId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }
}