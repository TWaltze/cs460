<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/User.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Alert.php");

class UserCtrl {
    public static function create($email, $password, $firstName, $lastName, $dob) {
        if(!trim($email) || !trim($password) || !trim($firstName) || !trim($lastName) || !trim($dob)) {
            return new Alert("danger", "All fields are required.");
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new Alert("danger", "Invalid email.");
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
            return new Alert("danger", $e->getMessage());
        }
    }

    public static function login($email, $password) {
        if(!trim($email)) {
            return new Alert("danger", "Missing email.");
        } else if(!trim($password)) {
            return new Alert("danger", "Missing password.");
        } else {
            $auth = Auth::authenticate($email, $password);

            if(!$auth) {
                return new Alert("danger", "Invalid username or password.");
            } else {
                header('Location: /index.php');
            }
        }
    }

    public static function friend($uid) {
        if(!Auth::isLoggedIn()) {
            return new Alert("danger", "You must be logged in to friend {$user->firstName}.");
        }

        $user = User::find($uid);
        $current = Auth::loggedInAs();

        if($user->isFriendsWith($current)) {
            $user->removeFriend($current);

            return new Alert("success", "You unfriended {$user->firstName}.");
        } else {
            $user->addFriend($current);

            return new Alert("success", "You friended {$user->firstName}.");
        }
    }

    public static function deleteAlbum($aid) {
        if(!Auth::isLoggedIn()) {
            return new Alert("danger", "You must be logged in to delete an album.");
        }

        $album = Album::find($aid);

        if($album->owner == Auth::loggedInAs()) {
            $album->delete();
            return new Alert("success", "You deleted the album {$album->name}.");
        } else {
            return new Alert("danger", "You can only delete albums you own.");
        }
    }
}
?>
