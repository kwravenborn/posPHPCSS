<?php


$servername = "localhost";
$username = "root";
$password = "g4O1p7C22oh12";

try {
  $conn = new PDO("mysql:host=$servername;dbname=pos", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

class DBcontroller {

  private $host = "localhost";
  private $user = "root";
  private $password = "g4O1p7C22oh12";
  private $database = "pos";
  private $conn;

  function _construct() {
    $this->conn = $this->connectDB();
  }

  function connectDB() {
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
    return $conn;
  }

  function runQuery($query) {
    $result = mysqli_query($this->conn, $query);

    while($row = mysqli_fetch_assoc($result)) {
      $resultset[] = $row;
    }
    if(!empty($result)) {
      return $resultset;
    }
  }

  function numRows($query) {
    $result = mysqli_query($this->conn,$query);
    $rowcount = mysqli_num_rows($result);
    return $rowcount;
  }

}

?>