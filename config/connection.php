<?php

class Connection{

private $servername="localhost:3306";
private $username="root";
private $password="";
private $dbname="location";
public $conn;

public function __construct(){
   // Create connection
$this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
// Check connection
 if (!$this->conn) {
die("Connection failed: " . mysqli_connect_error());
}
//  echo "Connected successfully";
}
public function getConnection() {
    return $this->conn;
}

function createDatabase($dbName){
    // // Create database
$sql = "CREATE DATABASE $dbName";
 if (mysqli_query($this->conn, $sql)) {
echo "Database created successfully";
} else {
echo "Error creating database: " . mysqli_error($this->conn);
}
}

function selectDatabase($dbName){
    //select database with the conn of the class, using mysqli_select..
    mysqli_select_db($this->conn,$dbName);
}

function createTable($queries){

    foreach ($queries as $query) {

        if (mysqli_query($this->conn, $query)) {
            echo "Table created successfully<br>";
        } else {
            echo "Error creating table: " . mysqli_error($this->conn) . "<br>";
        }

    }
}


}

?>

