<?php
class DBConnection {
    private $name = "picshare";         //DB Name
    private $host = "localhost";        //DB Host
    private $username = "root";			//DB Username
    private $password = "root";         //DB Password
    private $port = 8889;			    //SQL port

    private $db = null;                 // PDO object

	public function __construct() {
        $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->name;charset=UTF8";
        $this->db = new PDO($dsn, $this->username, $this->password);
	}

    public function query($query, $params) {
        $statement = $this->db->prepare($query);
        $statement->execute($params);

        return $statement;
    }

    public function db() {
        return $this->db;
    }
}
?>
