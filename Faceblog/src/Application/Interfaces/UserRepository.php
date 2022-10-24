<?php

namespace Application\Interfaces;

interface UserRepository {
    public function getUser(int $id): ?\Application\Entities\User; //? heißt "oder null"
    public function getUserForUserName(string $userName): ?\Application\Entities\User;
    public function getUserCount(): ?int;
    public function insertUser(string $displayName, string $username, string $password): int;
    public function getUsersForDisplayname(string $dnm): ?array;
}