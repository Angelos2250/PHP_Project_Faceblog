<?php


namespace Application;


use Application\Entities\User;
use Application\Interfaces\UserRepository;

class UserByDisplaynameQuery {
    public function __construct(private UserRepository $userRepository) {
    }

    public function execute(?string $dnm): ?array{
        $user = $this->userRepository->getUsersForDisplayname($dnm);
        $userDTO = [];
        foreach ($user as $p) {
            $userDTO[] = new User($user->getUsersId(), $user->getDisplayname(),$user->getUsername(),$user->getPasswordHash());
        }
        return $userDTO;
    }

}