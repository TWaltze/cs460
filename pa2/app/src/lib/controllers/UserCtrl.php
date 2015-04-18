<?php
require('../models/User.php');

class UserCtrl {
    public static function create($email, $password) {
        $user = new User();
        $user->email = $email;
        $user->setPassword(UserCtrl::hashPassword($password));

        $response = $user->create();

        return $user->getUID();
    }

    public static function hashPassword($password) {
        return $password;
    }
}
?>
