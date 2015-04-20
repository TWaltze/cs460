<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/controllers/DBConnection.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Album.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Photo.php");

class User {
    public $email = null;
    public $firstName = null;
    public $lastName = null;
    public $dob = null;
    public $gender = null;
    public $city = null;
    public $state = null;
    public $country = null;
    public $school = null;

    private $uid = null;
    private $password = null;

    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    public function getUID() {
        return $this->uid;
    }

    public function create() {
        $db = new DBConnection();

        if($db->query("SELECT * FROM users WHERE email = ?", [$this->email])->rowCount() > 0) {
            throw new Exception("This email is already being used.");
        }

        $result = $db->query("INSERT INTO users (
            email,
            password,
            firstName,
            lastName,
            dob,
            gender,
            city,
            state,
            country,
            school
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
            $this->email,
            $this->password,
            $this->firstName,
            $this->lastName,
            $this->dob,
            $this->gender,
            $this->city,
            $this->state,
            $this->country,
            $this->school
        ]);

        $this->uid = $db->db()->lastInsertId();
        return $this;
    }

    public function save() {
        $db = new DBConnection();

        $result = $db->query("UPDATE users SET
            email = ?,
            firstName = ?,
            lastName = ?,
            dob = ?,
            gender = ?,
            city = ?,
            state = ?,
            country = ?,
            school = ?
            WHERE uid = ?", [
                $this->email,
                $this->firstName,
                $this->lastName,
                $this->dob,
                $this->gender,
                $this->city,
                $this->state,
                $this->country,
                $this->school,
                $this->uid
            ]
        );

        return $this;
    }

    public static function find($uid) {
        $db = new DBConnection();
        $result = $db->query("SELECT * FROM users WHERE uid = ?", [$uid]);

        // var_dump($result->errorInfo());

        $info = $result->fetchObject();

        $user = new User();
        $user->uid = $info->uid;
        $user->email = $info->email;
        $user->password = $info->password;
        $user->firstName = $info->firstName;
        $user->lastName = $info->lastName;
        $user->dob = $info->dob;
        $user->gender = $info->gender;
        $user->city = $info->city;
        $user->state = $info->state;
        $user->country = $info->country;
        $user->school = $info->school;

        return $user;
    }

    public function getAlbums() {
        $db = new DBConnection();
        $result = $db->query("SELECT * FROM albums WHERE owner = ?", [$this->uid]);

        $albums = $result->fetchAll();

        $a = [];
        foreach ($albums as $album) {
            $a[] = Album::convertFromDBObject($album);
        }

        return $a;
    }

    public function getPhotos() {
        $db = new DBConnection();
        $result = $db->query("SELECT * FROM photos WHERE owner = ?", [$this->uid]);

        $photos = $result->fetchAll();

        $p = [];
        foreach ($photos as $photo) {
            $p[] = Photo::convertFromDBObject($photo);
        }

        return $p;
    }

    public function getComments() {
        $db = new DBConnection();
        $result = $db->query("SELECT * FROM comments WHERE author = ?", [$this->uid]);

        $comments = $result->fetchAll();
        return $comments;
    }

    public function addFriend($user) {
        $db = new DBConnection();
        $result = $db->query("INSERT INTO friends (
            firstFriend,
            secondFriend
        ) VALUES (?, ?)", [
            $this->uid,
            $user
        ]);

        return $this;
    }

    public function removeFriend($user) {
        $db = new DBConnection();
        $result = $db->query("DELETE FROM friends WHERE
            (firstFriend = ? AND secondFriend = ?) OR
            (firstFriend = ? AND secondFriend = ?)",
            [
                $this->uid,
                $user,
                $user,
                $this->uid
            ]
        );

        return $this;
    }

    public function getFriends() {
        $db = new DBConnection();
        $result = $db->query("SELECT * FROM friends WHERE firstFriend = ? OR secondFriend = ?", [$this->uid, $this->uid]);

        $friends = $result->fetchAll();
        return $friends;
    }
}
?>
