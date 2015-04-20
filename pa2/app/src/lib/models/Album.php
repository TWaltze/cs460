<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/controllers/DBConnection.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Photo.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/Utils/timeAgo.php");

class Album {
    public $name = null;
    public $owner = null;

    private $aid = null;
    private $createdAt = null;

    public function getAID() {
        return $this->aid;
    }

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

    public function save() {
        $db = new DBConnection();
        $result = $db->query("UPDATE albums SET name = ? WHERE aid = ?", [
            $this->name,
            $this->aid
        ]);

        return $this;
    }

    public function delete() {
        $db = new DBConnection();
        $deletePhotos = $db->query("DELETE FROM photos WHERE album = ?", [$this->aid]);
        $deleteAlbum = $db->query("DELETE FROM albums WHERE aid = ?", [$this->aid]);

        return true;
    }

    public static function find($aid) {
        $db = new DBConnection();
        $result = $db->query("SELECT * FROM albums WHERE aid = ?", [$aid]);

        $info = $result->fetchObject();

        $album = new Album();
        $album->aid = $info->aid;
        $album->name = $info->name;
        $album->owner = $info->owner;
        $album->createdAt = $info->createdAt;

        return $album;
    }

    public function getPhotos() {
        $db = new DBConnection();
        $result = $db->query("SELECT * FROM photos WHERE album = ?", [$this->aid]);

        $photos = $result->fetchAll();

        $p = [];
        foreach ($photos as $photo) {
            $p[] = Photo::convertFromDBObject($photo);
        }

        return $p;
    }

    public function timeAgo() {
        return timeAgo($this->createdAt);
    }

    public static function convertFromDBObject($obj) {
        $album = new Album();

        $album->aid = $obj['aid'];
        $album->name = $obj['name'];
        $album->owner = $obj['owner'];
        $album->createdAt = $obj['createdAt'];

        return $album;
    }
}
?>
