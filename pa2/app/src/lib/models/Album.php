<?php
require("../controllers/DBConnection.php");

class Album {
    public $name = null;
    public $owner = null;

    private $aid = null;
    private $createdAt = null;

    public function create() {
        $db = new DBConnection();
        $result = $db->query("INSERT INTO albums (
            name,
            owner
        ) VALUES (?, ?)", [
            $this->name,
            $this->owner,
        ]);

        // var_dump($result->errorInfo());

        $this->aid = $db->db()->lastInsertId();
        return $this;
    }

    public static function find($aid) {
        $db = new DBConnection();
        $result = $db->query("SELECT * FROM albums WHERE aid = ?", [$aid]);

        var_dump($result->errorInfo());

        $info = $result->fetchObject();

        $album = new Album();
        $album->aid = $info->aid;
        $album->name = $info->name;
        $album->owner = $info->owner;
        $album->createdAt = $info->createdAt;

        return $album;
    }

    public function getAID() {
        return $this->aid;
    }
}
?>
