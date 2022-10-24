<?php
namespace Presentation\Controllers;

class Home extends \Presentation\MVC\Controller {
public function __construct(
    private \Application\SignedInUserQuery      $signedInUserQuery,
    private \Application\BlogsCount             $blogsCount,
    private \Application\Blogs24Query           $blogs24Count,
    private \Application\LatestBlogDateQuery    $latestBlogDateQuery,
    private \Application\UserCount              $userCount
)
{ }

    public function GET_Index() : \Presentation\MVC\ActionResult {
        // TODO return action result!
        return $this->view('home', [
            'user' => $this->signedInUserQuery->execute(),
            'count' => $this->blogsCount->execute(),
            '24count' => $this->blogs24Count->execute(),
            'latest' => $this->latestBlogDateQuery->execute(),
            'userCount' => $this->userCount->execute()
        ]);
    }
}