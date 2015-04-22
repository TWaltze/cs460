<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Photo.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Album.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Alert.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/utils/Uploader.php");

class PhotoCtrl {
    public static function create($aid, $albumTitle, $image, $caption = null, $tags = null) {
        if(!Auth::isLoggedIn()) {
            return new Alert("danger", "You must be logged in to like a photo.");
        }

        $user = Auth::loggedInAs();

        // User is making a new album
        if(intval($aid) == 0) {
            if(!trim($albumTitle)) {
                return new Alert("danger", "You must select an album.");
            }

            $album = new Album();
            $album->name = $albumTitle;
            $album->owner = $user;

            $album->create();

            $aid = $album->getAID();
        }

        // Set properties
        $photo = new Photo();
        $photo->album = $aid;
        $photo->owner = $user;
        $photo->caption = $caption;

        // Upload image
        try {
            $uploader = new Uploader($image);
            $photo->data = $uploader->upload();
        } catch(Exception $e) {
            return new Alert("danger", $e->getMessage());
        }

        // Save photo to db
        $photo->create();

        // Spit comma deliminated string of tags into array
        $tags = explode(",", preg_replace('/\s+/', '', $tags));
        // Add tags
        foreach($tags as $tag) {
            $photo->addTag($tag);
        }

        return new Alert("success", "That's a great photo!");
    }

    public static function recommendTags($string, $amount = 5) {
        $db = new DBConnection();

        // Spit comma deliminated string of tags into array
        $tags = explode(",", preg_replace('/\s+/', '', $string));

        // Generate SQL WHERE clause
        $tagWhere = [];
        $params = [];
        foreach($tags as $tag) {
            $tagWhere[] = "tag = ?";
            $params[] = $tag;
        }
        $tagWhere = implode(" OR ", $tagWhere);

        // Find tags frequently used with the supplied tags
        $tagQuery = "
            SELECT *, COUNT(*) tagScore
            FROM
                (SELECT photo, COUNT(*) as tagCount
                FROM tags
                WHERE $tagWhere
                GROUP BY photo) as similarPhotos JOIN tags ON similarPhotos.photo = tags.photo
            GROUP BY tag
            ORDER BY tagScore DESC
            LIMIT ?
        ";

        // Result set will contain the supplied tags.
        // In order to get X new, recommended tags, you need
        // to search for X + {the number of tags supplied to search}
        $params[] = $amount + count($tags);

        $result = $db->query($tagQuery, $params);
        $frequentTags = $result->fetchAll();

        // Remove supplied tags from frequent result set
        $recommended = [];
        foreach($frequentTags as $tag) {
            if(!in_array($tag['tag'], $tags)) {
                $recommended[] = $tag['tag'];
            }
        }

        return $recommended;
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
