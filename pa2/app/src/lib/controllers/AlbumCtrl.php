<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Album.php");

class AlbumCtrl {
    public static function create($name) {
        if(!Auth::isLoggedIn()) {
            return new Alert("danger", "You must be logged in to like a photo.");
        }

        $album = new Album();
        $album->name = $name;
        $album->owner = Auth::loggedInAs();

        $response = $album->create();

        return $album->getAID();
    }
}
?>
