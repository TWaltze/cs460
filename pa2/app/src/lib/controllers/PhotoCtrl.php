<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Photo.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Album.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Alert.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/utils/Uploader.php");

class PhotoCtrl {
    public static function create($aid, $albumTitle, $image, $caption = null) {
        if(!Auth::isLoggedIn()) {
            return new Alert("danger", "You must be logged in to like a photo.");
        }

        $user = Auth::loggedInAs();

        // User is making a new album
        if(intval($aid) == 0) {
            $album = new Album();
            $album->name = $albumTitle;
            $album->owner = $user;

            $album->create();

            $aid = $album->getAID();
        }

        $photo = new Photo();
        $photo->album = $aid;
        $photo->owner = $user;
        $photo->caption = $caption;

        try {
            $uploader = new Uploader($image);
            $photo->data = $uploader->upload();
        } catch(Exception $e) {
            return new Alert("danger", $e->getMessage());
        }

        $photo->create();

        return new Alert("success", "That's a great photo!");
    }

    public static function like($pid) {
        if(!Auth::isLoggedIn()) {
            return new Alert("danger", "You must be logged in to like a photo.");
        }

        $photo = Photo::find($pid);
        $user = Auth::loggedInAs();

        if($photo->likedByUser($user)) {
            $photo->unlikeByUser($user);

            return new Alert("success", "You unliked this photo.");
        } else {
            $photo->likeByUser($user);

            return new Alert("success", "You liked this photo.");
        }
    }

    public static function comment($pid, $comment) {
        if(!trim($comment)) {
            return new Alert("danger", "You must enter a comment to leave a comment.");
        }

        $user = Auth::isLoggedIn() ? Auth::loggedInAs() : null;
        $photo = Photo::find($pid);

        try {
            $photo->comment($user, $comment);

            return new Alert("success", "Thanks for the comment.");
        } catch(Exception $e) {
            return new Alert("danger", $e->getMessage());
        }
    }
}
?>
