<?php

class DBcontroller {

  private $host = "localhost";
  private $user = "root";
  private $password = "g4O1p7C22oh12";
  private $database = "pos";
  private $conn;

  function __construct() {
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