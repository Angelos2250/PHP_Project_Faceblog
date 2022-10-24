<?php


namespace Application;

class RegisterCommand {

    public function __construct(
        private Interfaces\UserRepository $userRepository
    ) 
    {}

    public function execute(string $displayName, string $username, string $password): ?int {
        if ($this->userRepository->getUserForUserName($username) != null) {
            return null;
        }
        return $this->userRepository->insertUser($displayName,$username, $password);
    }

}