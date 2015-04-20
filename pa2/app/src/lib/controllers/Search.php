<?php
require("../controllers/DBConnection.php");

class Search {
    public static function topUsers($amount) {
        $db = new DBConnection();
        $result = $db->query("
        SELECT uid, email, firstName, lastName, points
        FROM (SELECT user, SUM(sum_piece) as points
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
            ORDER BY points DESC
            LIMIT ?) as top_users
        JOIN users on top_users.user = users.uid
        ", [$amount]);

        return $result->fetchAll();
    }
}
?>
