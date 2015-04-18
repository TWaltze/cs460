<?php
require('../models/Album.php');

class AlbumCtrl {
    public static function create($name) {
        $album = new Album();
        $album->name = $name;
        $album->owner = 1;

        $response = $album->create();

        return $album->getAID();
    }
}
?>
