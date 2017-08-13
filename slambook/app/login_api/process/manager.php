<?php
class manager
{
  private $conn;
  function __construct()
  {
    require_once 'DB_Connect.php';
    // connecting to database
    $db = new Db_Connect();
    $this->conn = $db->connect();
  }

  function __destruct()
  {

  }
  public function storeUser($name,$nickname,$dob)
  {
    $stmt = $this->conn->prepare("INSERT INTO users(uname,nickname,dob) VALUES(?, ?, ?)");
    $stmt->bind_param("sss",$name,$nickname,$dob);
    $result = $stmt->execute();
    $stmt->close();
    if ($result) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE uname = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $user;
    } else {
        return false;
    }
  }
  public function updateuser($name,$nickname,$dob)
  {
    $stmt= $this->conn->prepare("UPDATE users SET nickname= ?,dob= ? where uname= ?");
    $stmt->bind_param("sss",$nickname,$dob,$name);
    $result = $stmt->execute();
    $stmt->close();
    if ($result) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE uname = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $user;
    } else {
        return false;
    }

  }

  public function isUserExisted($email) {
      $stmt = $this->conn->prepare("SELECT uname from users WHERE uname = ?");

      $stmt->bind_param("s", $email);

      $stmt->execute();

      $stmt->store_result();

      if ($stmt->num_rows > 0) {
          // user existed
          $stmt->close();
          return true;
      } else {
          // user not existed
          $stmt->close();
          return false;
      }
  }


}

 ?>
