<?php

namespace Application;

class SignInCommand {
    public function __construct(
        private Services\AuthenticationService $authenticationService,
        private Interfaces\UserRepository $userRepository
    )
    {
        
    }

    public function execute(string $userName, string $password): bool {
        $this->authenticationService->signOut();
        $user = $this->userRepository->getUserForUserName($userName);
        if ($user != null && password_verify($password, $user->getPasswordHash())) {    //password_hash erstellt aus einem Password einen Hash
           $this->authenticationService->signIn($user->getUsersId());                        //password_verify stellt ein vorheriges password_hash voraus
            return true;
        }
        return false;
    }
}