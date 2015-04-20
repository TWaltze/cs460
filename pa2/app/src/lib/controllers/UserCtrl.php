<?php
require_once('../models/User.php');

class UserCtrl {
    public static function create($email, $password, $firstName, $lastName, $dob) {
        $user = new User();
        $user->email = $email;
        $user->firstName = $firstName;
        $user->lastName = $lastName;
        $user->dob = $dob;
        $user->setPassword(UserCtrl::hashPassword($password));

        try {
            $user->create();
            return $user;
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public static function hashPassword($password) {
        return $password;
    }
}
?>
