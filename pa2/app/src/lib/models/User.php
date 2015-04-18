<?php
require("../controllers/DBConnection.php");

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

    public function create() {
        $db = new DBConnection();
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

    public static function find($uid) {
        $db = new DBConnection();
        $result = $db->query("SELECT * FROM users WHERE uid = ?", [$uid]);

        var_dump($result->errorInfo());

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

    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    public function getUID() {
        return $this->uid;
    }
}
?>
