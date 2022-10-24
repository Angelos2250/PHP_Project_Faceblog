<?php

namespace Application;
class UserCount {
    public function __construct(
        private Interfaces\UserRepository $userRepository
    ) {
    }

    public function execute(): int {
        return $this->userRepository->getUserCount();
    }
}