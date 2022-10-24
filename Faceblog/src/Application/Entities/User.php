<?php

namespace Application\Entities;

class User {
    public function __construct(
        private int $usersId,
        private string $displayName,
        private string $userName,
        private string $passwordHash
    )
    {
        
    }

    /**
     * @return int
     */
    public function getUsersId(): int
    {
        return $this->usersId;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }
}