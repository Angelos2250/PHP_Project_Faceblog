<?php


namespace Application;

class CreateRatingCommand {
    public function __construct(
        private Interfaces\RatingsRepository $ratingsRepository,
        private SignedInUserQuery $signedInUserQuery
    ) {
    }

    public function execute(int $blogsId, int $usersId, int $rating): ?int {
        return $this->ratingsRepository->insertRating($blogsId,$usersId,$rating);
    }

}