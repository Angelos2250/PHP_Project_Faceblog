<?php

namespace Application\Interfaces;

interface RatingsRepository {
    public function getRatings() : array;
    public function getLikedBy(int $bid) : array;
    public function insertRating(int $blogsId, int $usersId, int $rating) : int;
    public function deleteRating(int $rid): int;
}