<?php

namespace Application\Entities;

class Ratings {
    public function __construct(
        private int $ratingsId,
        private int $blogsId,
        private int $usersId,
        private int $rating
    )
    { }

    /**
     * @return int
     */
    public function getRatingsId(): int
    {
        return $this->ratingsId;
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
    public function getBlogsId(): int
    {
        return $this->blogsId;
    }

    /**
     * @return int
     */
    public function getUsersId(): int
    {
        return $this->usersId;
    }


}