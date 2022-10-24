<?php
// === register autoloader
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});


// TODO: handle request
$sp = new \ServiceProvider();
// --- TODO: Account Created
// --- APPLICATION
$sp->register(\Application\BlogsCount::class);
$sp->register(\Application\UserCount::class);
$sp->register(\Application\SignedInUserQuery::class);
$sp->register(\Application\BlogsQuery::class);
$sp->register(\Application\PeopleQuery::class);
$sp->register(\Application\LikedByQuery::class);
$sp->register(\Application\RatingsQuery::class);
$sp->register(\Application\Blogs24Query::class);
$sp->register(\Application\LatestBlogDateQuery::class);
$sp->register(\Application\DeleteRatingCommand::class);
$sp->register(\Application\CreateRatingCommand::class);
$sp->register(\Application\SignInCommand::class);
$sp->register(\Application\BlogByIdQuery::class);
$sp->register(\Application\DeleteBlogCommand::class);
$sp->register(\Application\RegisterCommand::class);
$sp->register(\Application\SignOutCommand::class);
$sp->register(\Application\CreatePostCommand::class);
// --------- SERVICES
$sp->register(\Application\Services\AuthenticationService::class);
// --- PRESENTATION
$sp->register(\Presentation\MVC\MVC::class, function () {
    return new \Presentation\MVC\MVC();
}, isSingleton: true);
// controllers
$sp->register(\Presentation\Controllers\Blogs::class);
$sp->register(\Presentation\Controllers\Home::class);
$sp->register(\Presentation\Controllers\User::class);
$sp->register(\Presentation\Controllers\People::class);

// --- INFRASTRUCTURE
$sp->register(\Infrastructure\Session::class, isSingleton: true);   // !! Important damit start_session nur einmal aufgerufen wird
$sp->register(\Application\Interfaces\Session::class, \Infrastructure\Session::class);
$sp->register(\Infrastructure\Repository::class, implementation: function() {
    return new \Infrastructure\Repository('localhost', '', 'root', '', 'faceblog');}, isSingleton: true);
$sp->register(\Application\Interfaces\BlogsRepository::class, \Infrastructure\Repository::class);    //statt FakeRepo nur Repository hinschreiben
$sp->register(\Application\Interfaces\RatingsRepository::class, \Infrastructure\Repository::class);
$sp->register(\Application\Interfaces\UserRepository::class, \Infrastructure\Repository::class);

$sp->resolve(\Presentation\MVC\MVC::class)->handleRequest($sp);