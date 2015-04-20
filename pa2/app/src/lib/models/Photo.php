<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/controllers/DBConnection.php");

class Photo {
    public $album = null;
    public $owner = null;
    public $data = null;
    public $caption = null;

    private $pid = null;
    private $createdAt = null;

    public function getPID() {
        return $this->pid;
    }

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

        // var_dump($result->errorInfo());

        $this->pid = $db->db()->lastInsertId();
        return $this;
    }

    public function save() {
        $db = new DBConnection();
        $result = $db->query("UPDATE photos SET caption = ? WHERE pid = ?", [
            $this->caption,
            $this->pid
        ]);

        return $this;
    }

    public static function find($pid) {
        $db = new DBConnection();
        $result = $db->query("SELECT * FROM photos WHERE pid = ?", [$pid]);

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

    public function getComments() {
        $db = new DBConnection();
        $result = $db->query("SELECT * FROM comments WHERE photo = ?", [$this->pid]);

        $comments = $result->fetchAll();
        return $comments;
    }

    public function comment($user, $comment) {
        $db = new DBConnection();

        if($this->owner === $user) {
            throw new Exception("You cannot comment on your own photos.");
        }

        $result = $db->query("INSERT INTO comments (
            author,
            photo,
            comment
        ) VALUES (?, ?, ?)", [
            $user,
            $this->pid,
            $comment
        ]);

        return $this;
    }

    public function getLikes() {
        $db = new DBConnection();
        $result = $db->query("SELECT * FROM likes WHERE photo = ?", [$this->pid]);

        $likes = $result->fetchAll();
        return $likes;
    }

    public function getTags() {
        $db = new DBConnection();
        $result = $db->query("SELECT * FROM tags WHERE photo = ?", [$this->pid]);

        $tags = $result->fetchAll();
        return $tags;
    }

    public function addTag($tag) {
        $db = new DBConnection();
        $result = $db->query("INSERT INTO tags (
            tag,
            photo
        ) VALUES (?, ?)", [
            $tag,
            $this->pid
        ]);

        return $this;
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

        return $this;
    }
}
?>
