<?php
namespace Application;

use Application\Interfaces\UserRepository;

class PeopleQuery {
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    public function execute(?string $dnm): array {
        $res = [];
        if(!isset($dnm)){
            return $res;
        }
        $people = $this->userRepository->getUsersForDisplayname($dnm);
        foreach ($people as $p) {
            $res[] = new UserData(
                $p->getUsersId(),
                $p->getDisplayName(),
                $p->getUserName()
            );
        }
        return $res;    }

}
