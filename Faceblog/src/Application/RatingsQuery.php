<?php

namespace Application;
// Entwurfsmuster: CQRS

class RatingsQuery {
    public function __construct(
        private \Application\Interfaces\RatingsRepository $ratingsRepository
    )
    { }

    public function execute() : array {
        $count = $this->ratingsRepository->getRatings();
        return $count;
    }

}