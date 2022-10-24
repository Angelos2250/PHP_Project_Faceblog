<?php
namespace Application\Entities;

class Blogs {
    public function __construct(
        private int $blogsId,
        private int $users,
        private string $title,
        private string $text,
        private string $date
    )
    { }

    /**
     * @return int
     */
    public function getUsers(): int
    {
        return $this->users;
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