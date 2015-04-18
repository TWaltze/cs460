<?php
require("../controllers/DBConnection.php");

class Photo {
    public $album = null;
    public $owner = null;
    public $data = null;
    public $caption = null;

    private $pid = null;
    private $createdAt = null;

    public function create() {
        $db = new DBConnection();
        $result = $db->query("INSERT INTO photos (
            album,
            owner,
            data,
            caption
        ) VALUES (?, ?, ?, ?)", [
            $this->album,
            $this->owner,
            $this->data,
            $this->caption
        ]);

        var_dump($result->errorInfo());

        $this->pid = $db->db()->lastInsertId();
        return $this;
    }

    public static function find($pid) {
        $db = new DBConnection();
        $result = $db->query("SELECT * FROM photos WHERE pid = ?", [$pid]);

        var_dump($result->errorInfo());

        $info = $result->fetchObject();

        $photo = new Photo();
        $photo->pid = $info->pid;
        $photo->album = $info->album;
        $photo->owner = $info->owner;
        $photo->data = $info->data;
        $photo->caption = $info->caption;
        $photo->createdAt = $info->createdAt;

        return $photo;
    }

    public function getPID() {
        return $this->pid;
    }

    public function likeByUser($uid) {
        $db = new DBConnection();
        $result = $db->query("INSERT INTO likes (
            photo,
            user
        ) VALUES (?, ?)", [
            $this->pid,
            $uid
        ]);

        var_dump($result->errorInfo());

        return $this;
    }
}
?>
