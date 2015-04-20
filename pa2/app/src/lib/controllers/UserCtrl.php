<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/User.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Auth.php");

class UserCtrl {
    public static function create($email, $password, $firstName, $lastName, $dob) {
        if(!trim($email) || !trim($password) || !trim($firstName) || !trim($lastName) || !trim($dob)) {
            return "All fields are required.";
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return "Invalid email.";
		}

        $user = new User();
        $user->email = $email;
        $user->firstName = $firstName;
        $user->lastName = $lastName;
        $user->dob = $dob;
        $user->setPassword(Auth::hashPassword($password));

        try {
            $user->create();

            Auth::authenticate($email, $password);
            header('Location: /index.php');
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public static function login($email, $password) {
        if(!trim($email)) {
            return "Missing email.";
        } else if(!trim($password)) {
            return "Missing password.";
        } else {
            $auth = Auth::authenticate($email, $password);

            if(!$auth) {
                return "Invalid username or password.";
            } else {
                header('Location: /index.php');
            }
        }
    }

    public static function hashPassword($password) {
        return $password;
    }
}
?>
