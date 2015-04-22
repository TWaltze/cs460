<?php
require_once("DBConnection.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Photo.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/User.php");

class Search {
    public static function topUsers($amount) {
        $db = new DBConnection();
        $query = "
            SELECT *
            FROM (SELECT user, SUM(sum_piece) as contribution
                FROM (
                	SELECT owner as user, COUNT(*) as sum_piece
                	FROM photos
                	GROUP BY owner

                	UNION ALL

                	SELECT author as user, COUNT(*) as sum_piece
                	FROM comments
                	GROUP BY author
                ) as total_points
                GROUP BY user
                ORDER BY contribution DESC
                LIMIT ?) as top_users
            JOIN users on top_users.user = users.uid";

        $result = $db->query($query, [$amount]);

        $users = $result->fetchAll();

        $u = [];
        foreach ($users as $user) {
            $u[] = User::convertFromDBObject($user);
        }

        return $u;
    }

    public static function popularPhotos($amount) {
        $db = new DBConnection();

        $query = "
            SELECT *
            FROM (SELECT photo, COUNT(*) as likes
            	FROM likes
            	GROUP BY photo) as like_counts JOIN photos ON like_counts.photo = photos.pid
            ORDER BY likes DESC LIMIT ?";

        $result = $db->query($query, [$amount]);
        return $result->fetchAll();
    }

    public static function popularTags($amount) {
        $db = new DBConnection();

        $query = "SELECT tag, COUNT(*) as count FROM tags GROUP BY tag ORDER BY COUNT(*) DESC LIMIT ?";

        $result = $db->query($query, [$amount]);
        return $result->fetchAll();
    }

    public static function users($email) {
        $db = new DBConnection();

        $query = "SELECT * FROM users WHERE email = ?";

        $result = $db->query($query, [$email]);
        $users = $result->fetchAll();

        $u = [];
        foreach ($users as $user) {
            $u[] = User::convertFromDBObject($user);
        }

        return $u;
    }

    public static function photosByTag($tag, $user = null) {
        $db = new DBConnection();

        $query = "SELECT * FROM photos JOIN tags ON tags.photo = photos.pid WHERE tag LIKE ?";
        $params = [$tag];

        // Allow filtering by user
        if($user) {
            $query .= " AND owner = ?";
            $params[] = $user;
        }

        $query .= " ORDER BY createdAt DESC";

        $result = $db->query($query, $params);
        $photos = $result->fetchAll();

        $p = [];
        foreach ($photos as $photo) {
            $p[] = Photo::convertFromDBObject($photo);
        }

        return $p;
    }
}
?>
