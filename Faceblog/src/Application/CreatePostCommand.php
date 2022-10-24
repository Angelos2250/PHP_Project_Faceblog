<?php


namespace Application;

class CreatePostCommand {
    public function __construct(
        private Interfaces\BlogsRepository $blogsRepository,
        private SignedInUserQuery $signedInUserQuery
    ) {
    }

    public function execute(int $usersId, string $title, string $text, string $date): ?int {
        $user = $this->signedInUserQuery->execute();
        if (!isset($user)) {
            return null;
        }
        return $this->blogsRepository->insertBlog($user->getUsersId(), $title, $text, $date);
    }

}