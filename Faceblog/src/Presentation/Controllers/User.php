<?php

namespace Presentation\Controllers;

class User extends \Presentation\MVC\Controller {
    public function __construct(
        private \Application\SignInCommand $signInCommand,
        private \Application\SignOutCommand $signOutCommand,
        private \Application\RegisterCommand $registerCommand,
        private \Application\SignedInUserQuery $signedInUserQuery
        )
        {
            
        }

    private function signedInUser(): bool {
        return $this->signedInUserQuery->execute() != null;
    }

    public function GET_LogIn(): \Presentation\MVC\ActionResult {
        return $this->view('login', [
            'user' => $this->signedInUserQuery->execute(),
            'userName' => ''    // weil erstmaliger Aufruf der Login Page // '' <=> null <=> 0
        ]);
    }

    public function POST_LogIn(): \Presentation\MVC\ActionResult {
        // Try to authenticate given uer
        if(!$this->signInCommand->execute($this->getParam('un'), $this->getParam('pwd'))) {
            // authentication failed - nothing has changed, show view with error informaion
            return $this->view('login', [
                'user' => $this->signedInUserQuery->execute(),
                'userName' => $this->getParam('un'),
                'errors' => [ 'Invalid user name or password.' ]
            ]);
        }
        return $this->redirect('Home', 'Index');
    }

    public function POST_LogOut(): \Presentation\MVC\ActionResult {
        // sign out current user
        $this->signOutCommand->execute();
        return $this->redirect('Home', 'Index');
    }

    public function GET_Register(): \Presentation\MVC\ActionResult {
        if ($this->signedInUser()) {
            return $this->redirect("Home", "Index");
        }
        return $this->view("register", ['user' => $this->signedInUserQuery->execute()]);
    }

    public function POST_Register(): \Presentation\MVC\ActionResult {
        if ($this->signedInUser()) {
            return $this->redirect("Home", "Index");
        }
        $displayName = $this->getParam("displayName");
        $username = $this->getParam("username");
        $password = $this->getParam("password");
        $repeatPassword = $this->getParam("repeat-password");
        $errors = array();
        if (strlen($username) < 3) {
            array_push($errors, "Username has to be longer than 2 characters");
        }
        if (strlen($username) > 45) {
            array_push($errors, "Username can only have 45 characters");
        }
        if (strlen($password) < 4) {
            array_push($errors, "The password must be at least 4 characters long");
        }
        if (strlen($password) > 255) {
            array_push($errors, "Password can only have 255 characters");
        }
        if ($password !== $repeatPassword) {
            array_push($errors, "Passwords do not match");
        }
        if (count($errors) === 0) {
            $id = $this->registerCommand->execute($displayName,$username, $password);
            if ($id == null) {
                array_push($errors, "Username already in use");
            }
        }
        if (count($errors) > 0) {
            return $this->view("register", [
                'errors' => $errors,
                'username' => $username
            ]);
        }
        $this->signInCommand->execute($username, $password);
        return $this->redirect("Home", "Index");
    }

}