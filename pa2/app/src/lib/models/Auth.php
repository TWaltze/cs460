<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/controllers/DBConnection.php");

class Auth {
    public static function isLoggedIn() {
        return $_SESSION['logged'];
    }

    public static function loggedInAs() {
        return $_SESSION['uid'];
    }

    public static function authenticate($email, $password) {
        $db = new DBConnection();
        $result = $db->query("SELECT password FROM users WHERE email = ?", [$email]);

        if($result->rowCount() > 0 && Auth::validatePassword($password, $result->fetchObject()->password)) {
            $_SESSION['logged'] = true;
            $_SESSION['uid'] = 1;

            return true;
        } else {
            return false;
        }
    }

    public static function logout() {
        session_destroy();
        header('Location: /index.php');
    }

    // Blowfish hashing function with random 22 char salt
	public static function hashPassword($password, $rounds = 12) {
		$salt = substr(sha1(mt_rand()), 0, 22);
		$hash = crypt($password, "$2a$$rounds$$salt");
		return $hash;
	}

    public static function validatePassword($supplied, $correct) {
        return crypt($supplied, $correct) === $correct;

    }
}
?>
