<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Photo.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Alert.php");

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
