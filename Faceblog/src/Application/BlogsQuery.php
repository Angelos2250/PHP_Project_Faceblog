<?php

namespace Application;
// Entwurfsmuster: CQRS

class BlogsQuery {
    public function __construct(
        private \Application\Interfaces\BlogsRepository $blogsRepository,
        private \Application\LikedByQuery $likedByQuery,
        private \Application\Interfaces\RatingsRepository $ratingsRepository
    )
    { }

    public function execute(string $usersId) : array {
        $blogs = $this->blogsRepository->getBlogsForUser($usersId);
        $ratings = $this->ratingsRepository->getRatings();
        $res = [];
        foreach($blogs as $b) {
            $rating = 0;
            foreach($ratings as $r) {
                if ($r->getBlogsId() == $b->getBlogsId()){
                    $rating = $r->getRating();
                }
            }
            $res[] = new BlogsData($b->getBlogsId(), $b->getTitle(), $b->getText(),$b->getDate(),$rating,$this->likedByQuery->execute($b->getBlogsId()));
        }
        return $res;
    }

}