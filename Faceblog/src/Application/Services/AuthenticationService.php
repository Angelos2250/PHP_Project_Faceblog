<?php

namespace Application\Services;

class AuthenticationService {   // kein http Token oda so
    public function __construct(
        private \Application\Interfaces\Session $session
    ) {}

    const KEY = 'userId';

    public function getUserid(): ?int {
        return $this->session->get(self::KEY);
    }

    public function signIn(int $userId): void {
        $this->session->put(self::KEY, $userId);
    }

    public function signOut(): void {
        $this->session->delete(self::KEY);
    }
}