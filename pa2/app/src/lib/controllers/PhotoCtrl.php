<?php
require('../models/Photo.php');

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
        $photo = Photo::find($pid);

        return $photo->likeByUser(2);
    }
}

var_dump(PhotoCtrl::like(10));
?>
