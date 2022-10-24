<?php
namespace Presentation\Controllers;

class People extends \Presentation\MVC\Controller {
    public function __construct(
        private \Application\SignedInUserQuery $signedInUserQuery,
        private \Application\PeopleQuery $peopleQuery
    )
    { }
    public function GET_Index() : \Presentation\MVC\ActionResult {
        $this->tryGetParam('nameSearch', $dnm);
        return $this->view('people', [
            'user' => $this->signedInUserQuery->execute(),
            'people' => $this->peopleQuery->execute($dnm),
            'returnUrl' => $this->getRequestUri()]);
    }

    public function POST_Search(): \Presentation\MVC\ActionResult {
        $this->tryGetParam('dnm', $search);
        return $this->redirect("People", "Index", ['nameSearch' => $search]);
    }
}