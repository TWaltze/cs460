<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Photo.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Auth.php");

class PhotoCtrl {
    public static function create($album, $data, $caption = null) {
        $photo = new Photo();
        $photo->album = $album;
        $photo->owner = 1;
        $photo->data = $data;
        $photo->caption = $caption;

        $response = $photo->create();

        return $photo->getPID();
    }

    public static function like($pid) {
        if(!Auth::isLoggedIn()) {
            return false;
        }

        $photo = Photo::find($pid);
        $user = Auth::loggedInAs();

        if($photo->likedByUser($user)) {
            $photo->unlikeByUser($user);
        } else {
            $photo->likeByUser($user);
        }

        return true;
    }
}
?>
