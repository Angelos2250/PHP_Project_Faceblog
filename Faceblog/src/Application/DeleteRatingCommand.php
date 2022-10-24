<?php


namespace Application;

class DeleteRatingCommand {
    public function __construct(
        private Interfaces\RatingsRepository $ratingsRepository
    ) {
    }

    public function execute(int $rid): bool {
        return $this->ratingsRepository->deleteRating($rid);
    }
}