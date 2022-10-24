<?php

namespace Presentation\Controllers;

class Blogs extends \Presentation\MVC\Controller {
    public function __construct(
        private \Application\BlogsQuery $blogsQuery,
        private \Application\LikedByQuery $likedByQuery,
        private \Application\RatingsQuery $ratingsQuery,
        private \Application\BlogByIdQuery $blogByIdQuery,
        private \Application\CreateRatingCommand $createRatingCommand,
        private \Application\DeleteRatingCommand $deleteRatingCommand,
        private \Application\DeleteBlogCommand $deleteBlogCommand,
        private \Application\SignedInUserQuery $signedInUserQuery,
        private  \Application\CreatePostCommand $createPostCommand
        )
    { }

    public function GET_Index(): \Presentation\MVC\ActionResult {
        $user = $this->signedInUserQuery->execute();
        $this->tryGetParam('dpn', $dnm);
        if ($this->tryGetParam('uid', $id)) {
            $uid = $id;
            $dpn = $dnm;
        }
        elseif ($this->tryGetParam('bid', $id)){
            $uid = $id;
            $dpn = $user->getDisplayName();
        }
        else{
            $uid = null;
            $dpn = 'null';
        }
        return $this->view('blogsList', [
            'user' => $this->signedInUserQuery->execute(),
            'displaynm' => $dpn,
            'euser' => $uid,
            'blogs' => $this->blogsQuery->execute($uid),
            'ratings' => $this->ratingsQuery->execute(),
            'returnUrl' => $this->getRequestUri()
        ]);
    }
    public function POST_Search(): \Presentation\MVC\ActionResult {
        $this->tryGetParam('uid', $search);
        $this->tryGetParam('dpn', $search2);
        return $this->redirect("Blogs", "Index", ['uid' => $search,'dpn' => $search2]);
    }

    public function POST_Like(): \Presentation\MVC\ActionResult {
        $allRatings = $this->ratingsQuery->execute();
        $user = $this->signedInUserQuery->execute();
        $this->tryGetParam('blog', $blog);
        foreach ($allRatings as $rating){
            if ($user->getUsersId() == $rating->getUsersId() and $blog == $rating->getBlogsId()){ //IF already Liked
                $this->deleteRatingCommand->execute($rating->getRatingsId());
                return $this->redirectToUri($this->getParam('returnUrl'));
            }
        }
        $this->createRatingCommand->execute($blog,$user->getUsersId(),1);
        return $this->redirect("Blogs", "Index",['uid' => $user->getUsersId(),'dpn' => $user->getDisplayName()]);
    }

    public function GET_NewPost(): \Presentation\MVC\ActionResult {
        $user = $this->signedInUserQuery->execute();
        if ($user == null) {
            return $this->redirect("Home", "Index");
        }
        $data = [
            "user" => $this->signedInUserQuery->execute(),
            "blogs" => $this->blogsQuery->execute(),
        ];
        if ($this->tryGetParam('title', $title)) {
            $data['title'] = $title;
        }
        if ($this->tryGetParam('text', $text)) {
            $data['text'] = $text;
        }
        return $this->view("blogsList", $data);
    }

    public function POST_NewPost(): \Presentation\MVC\ActionResult {
        date_default_timezone_set('Europe/Vienna');
        $now = date('m/d/Y h:i:s a', time());
        $user = $this->signedInUserQuery->execute();
        if ($user == null) {
            return $this->redirect("Home", "Index");
        }
        $errors = [];
        if (!$this->tryGetParam('title', $title)) {
            $errors[] = "Title required";
        } elseif(strlen($title) > 255) {
            $errors[] = "Title can't be longer than 255 characters";
        }
        if (!$this->tryGetParam('text', $text)) {
            $errors[] = "text required";
        }
        if (count($errors) == 0) {
            $bid = $this->createPostCommand->execute($user->getUsersId(), $title, $text, $now);
            if (isset($bid)) {
                return $this->redirectToUri($this->getParam('returnUrl'));
            }
        }
        return $this->redirectToUri($this->getParam('returnUrl'));
    }

    public function POST_Delete(): \Presentation\MVC\ActionResult {
        $user = $this->signedInUserQuery->execute();

        if ($user == null) {
            return $this->redirectToUri($this->getParam('returnUrl'));
        }
        $bid = null;
        $errors = [];
        $rating = null;
        if ($this->tryGetParam('bid', $bid)) {
            $rating = $this->blogByIdQuery->execute($bid);
        } else {
            $errors[] = 'Blog does not Exist';
        }
        $this->deleteBlogCommand->execute($rating->getBlogsId());
        return $this->redirectToUri($this->getParam('returnUrl'));
    }
}