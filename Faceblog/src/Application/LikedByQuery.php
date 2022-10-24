<?php

namespace Application;

class LikedByQuery {
    public function __construct(
        private \Application\Interfaces\RatingsRepository $ratingsRepository
    )
    { }

    public function execute(int $bid) : array {
        $count = $this->ratingsRepository->getLikedBy($bid);
        return $count;
    }
}