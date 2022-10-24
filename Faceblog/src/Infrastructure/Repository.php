<?php

namespace Infrastructure;

use Application\Entities\Blogs;
use Application\Entities\Ratings;
use Application\Entities\User;
use Application\UserData;

class Repository
implements
    \Application\Interfaces\BlogsRepository,
    \Application\Interfaces\RatingsRepository,
    \Application\Interfaces\UserRepository
{
    private $server;
    private $displayName;
    private $userName;
    private $password;
    private $database;

    public function __construct(string $server, string $displayName, string $userName, string $password, string $database)
    {
        $this->server = $server;
        $this->displayName = $displayName;
        $this->userName = $userName;
        $this->password = $password;
        $this->database = $database;
    }

    // === private helper methods ===

    private function getConnection()
    {
        $con = new \mysqli($this->server, $this->userName, $this->password, $this->database);
        if (!$con) {
            die('Unable to connect to database. Error: ' . mysqli_connect_error());
        }
        return $con;
    }

    private function executeQuery($connection, $query)
    {
        $result = $connection->query($query);
        if (!$result) {
            die("Error in query '$query': " . $connection->error);
        }
        return $result;
    }

    private function executeStatement($connection, $query, $bindFunc)
    {
        $statement = $connection->prepare($query);
        if (!$statement) {
            die("Error in prepared statement '$query': " . $connection->error);
        }
        $bindFunc($statement);
        if (!$statement->execute()) {
            die("Error executing prepared statement '$query': " . $statement->error);
        }
        return $statement;
    }

    // === public methods ===

    public function insertUser(string $displayName ,string $username, string $password): int {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'INSERT INTO users (displayName, username, passwordHash) VALUES (?, ?, ?)',
            function (\mysqli_stmt $stmt) use ($displayName, $username, $hash) {
                $stmt->bind_param('sss',$displayName,$username, $hash);
            }
        );
        return $statement->insert_id;
    }

    public function getBlogsForUser($usersId): array
    {
        $Blogs = [];
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT blogsId, usersId, title, text, date FROM blogs WHERE usersId = ?',
            function ($s) use ($usersId) {
                $s->bind_param('i', $usersId);
            }
        );
        $stat->bind_result($blogsId, $usersId, $title, $text, $date);
        while ($stat->fetch()) {
            $Blogs[] = new \Application\Entities\Blogs($blogsId, $usersId, $title, $text, $date);
        }
        $stat->close();
        $con->close();
        return $Blogs;
    }

    public function getBlogsCount(): ?int
    {
        $count = null;
        $con = $this->getConnection();
        $res = $this->executeQuery(
            $con,
            'SELECT COUNT(*) as cnt FROM blogs'
        );
        if($row = $res->fetch_object()){
            $count = $row->cnt;
        }
        $res->close();
        $con->close();
        return $count;
    }

    public function getUserCount(): ?int
    {
        $count = null;
        $con = $this->getConnection();
        $res = $this->executeQuery(
            $con,
            'SELECT COUNT(*) as cnt FROM users'
        );
        if($row = $res->fetch_object()){
            $count = $row->cnt;
        }
        $res->close();
        $con->close();
        return $count;
    }

    public function getUser(int $id): ?\Application\Entities\User
    {
        $user = null;
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT usersId, displayname, userName, passwordHash FROM users WHERE usersId = ?',
            function ($s) use ($id) {
                $s->bind_param('i', $id);
            }
        );
        $stat->bind_result($usersId,$displayName, $userName, $passwordHash);
        if ($stat->fetch()) {
            $user = new \Application\Entities\User($usersId, $displayName, $userName, $passwordHash);
        }
        $stat->close();
        $con->close();
        return $user;
    }

    public function getUserForUserName(string $userName): ?\Application\Entities\User
    {
        $user = null;
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT usersId, displayName,userName, passwordHash FROM users WHERE userName = ?',
            function ($s) use ($userName) {
                $s->bind_param('s', $userName);
            }
        );
        $stat->bind_result($usersId, $displayName, $userName, $passwordHash);
        if ($stat->fetch()) {
            $user = new \Application\Entities\User($usersId, $displayName, $userName, $passwordHash);
        }
        $stat->close();
        $con->close();
        return $user;
    }

    public function getRatings(): array
    {
        $ratings = [];
        $con = $this->getConnection();
        $res = $this->executeQuery(
            $con,
            'SELECT ratings.ratingsId as rid,ratings.blogsId as bid,ratings.usersId as uid, COUNT(ratings.ratingsId) AS cnt FROM blogs RIGHT JOIN ratings ON blogs.blogsId = ratings.blogsId GROUP BY blogs.blogsId'
        );
        while($row = $res->fetch_object()){
            $ratings[] = new Ratings($row->rid,$row->bid,$row->uid,$row->cnt);
        }
        $res->close();
        $con->close();
        return $ratings;
    }

    public function insertBlog(int $usersId, string $title, string $text, string $date): int
    {
        $conn = $this->getConnection();
        $newDate = date('Y-m-d h:i:s', strtotime($date));
        $statement = $this->executeStatement(
            $conn,
            'INSERT INTO blogs (usersId, title, text, date) VALUES (?, ?, ?, ?)',
            function (\mysqli_stmt $stmt) use ($usersId, $title, $text, $newDate) {
                $stmt->bind_param('isss', $usersId, $title, $text, $newDate);
                $stmt->bind_param('isss', $usersId, $title, $text, $newDate);
            }
        );
        return $statement->insert_id;
    }

    public function getBlogById($blogsId): Blogs
    {
        $blog = null;
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT blogsId, usersId, title, text, date FROM blogs WHERE blogsId = ?',
            function ($s) use ($blogsId) {
                $s->bind_param('i', $blogsId);
            }
        );
        $stat->bind_result($blogsId, $usersId, $title, $text, $date);
        if ($stat->fetch()) {
            $blog = new \Application\Entities\Blogs($blogsId, $usersId, $title, $text, $date);
        }
        $stat->close();
        $con->close();
        return $blog;
    }

    public function deleteBlog($blogsId): int
    {
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'DELETE FROM blogs WHERE blogsId = ?',
            function (\mysqli_stmt $stmt) use ($blogsId) {
                $stmt->bind_param("i", $blogsId);
            }
        );
        return $statement->affected_rows > 0;
    }

    public function getUsersForDisplayname(?string $dnm): ?array
    {
        if (!isset($dnm)) {
            $dnm = "%";
        }
        $people = [];
        $conn = $this->getConnection();
        $result = $this->executeStatement(
            $conn,
            'SELECT usersId, displayName, userName FROM users WHERE displayName LIKE ?',
            function (\mysqli_stmt $stmt) use ($dnm) {
                $stmt->bind_param("s", $dnm);
            }
        );
        $result->bind_result($usersId, $displayName, $userName);
        while ($result->fetch()) {
            $people[] = new UserData(
                $usersId,
                $displayName,
                $userName
            );
        }
        return $people;
    }

    public function insertRating(int $blogsId, int $usersId, int $rating): int
    {
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'INSERT INTO ratings (blogsId, usersId, rating) VALUES (?, ?, ?)',
            function (\mysqli_stmt $stmt) use ($blogsId, $usersId, $rating) {
                $stmt->bind_param('iii', $blogsId, $usersId, $rating);
            }
        );
        return $statement->insert_id;
    }

    public function getBlogs24Count(): ?int
    {
        $count = null;
        $con = $this->getConnection();
        $res = $this->executeQuery(
            $con,
            'SELECT COUNT(*) as cnt FROM blogs WHERE date >= now() - INTERVAL 1 DAY;'
        );
        if($row = $res->fetch_object()){
            $count = $row->cnt;
        }
        $res->close();
        $con->close();
        return $count;
    }

    public function getLatestBlog(): ?string
    {
        $count = null;
        $con = $this->getConnection();
        $res = $this->executeQuery(
            $con,
            'SELECT MAX(date) as cnt FROM blogs;'
        );
        if($row = $res->fetch_object()){
            $count = $row->cnt;
        }
        $res->close();
        $con->close();
        return $count;
    }

    public function deleteRating(int $rid): int
    {
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'DELETE FROM ratings WHERE ratingsId = ?',
            function (\mysqli_stmt $stmt) use ($rid) {
                $stmt->bind_param("i", $rid);
            }
        );
        return $statement->affected_rows > 0;
    }
    //SELECT ratings.blogsId as bid, users.displayName as dpn FROM ratings JOIN users ON ratings.usersId = users.usersId WHERE ratings.blogsId = 46;
    public function getLikedBy(int $bid): array
    {
        $names[] = null;
        $conn = $this->getConnection();
        $result = $this->executeStatement(
            $conn,
            'SELECT users.displayName as dpn FROM ratings JOIN users ON ratings.usersId = users.usersId WHERE ratings.blogsId = ?;',
            function (\mysqli_stmt $stmt) use ($bid) {
                $stmt->bind_param("i", $bid);
            }
        );
        $result->bind_result($dnm);
        while ($result->fetch()) {
            $names[] = $dnm;
        }
        return $names;
    }
}
