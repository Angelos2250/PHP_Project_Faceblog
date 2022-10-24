<?php

namespace Application;

class UserData
{
    public function __construct(
        private int $usersId,
        private string $displayName,
        private string $userName
    ) {
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

}
