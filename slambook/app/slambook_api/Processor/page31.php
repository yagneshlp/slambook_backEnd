<?php
class page31
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
  {  }


 public function isUserExisted($userid)
 {
    $stmt = $this->conn->prepare("SELECT userid from pagination WHERE userid = ?");
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0)
    {
        // user existed
        $stmt->close();
        return true;
    }
    else
     {
        // user not existed
        $stmt->close();
        return false;
    }
 }

 public function update($uid,$uname,$req,$val)
{
  $stmt= $this->conn->prepare("UPDATE pagination SET page? = ? where userid= ?");
  $stmt->bind_param("sss",$req,$val,$uid);
  $result = $stmt->execute();
  $stmt->close();
  if ($result) {
      $stmt = $this->conn->prepare("SELECT * FROM pagination WHERE userid = ?");
      $stmt->bind_param("s", $uid);
      $stmt->execute();
      $user = $stmt->get_result()->fetch_assoc();
      $stmt->close();
      return $user;
  } else {
      return false;
  }
}

 public function storeuser($uid,$uname,$req,$val)
{
  $stmt = $this->conn->prepare("INSERT INTO pagination(userid,user_name, ?) VALUES( ?, ?, ?)");
  $stmt->bind_param("ssss",$req,$uid,$uname,$val);
  $result = $stmt->execute();
  $stmt->close();
  if ($result) {
      $stmt = $this->conn->prepare("SELECT * FROM pagination WHERE userid = ?");
      $stmt->bind_param("s", $uid);
      $stmt->execute();
      $user = $stmt->get_result()->fetch_assoc();
      $stmt->close();
      return $user;
  } else {
      return false;
  }
}

  public function returnuser($uid,$uname)
{
  $stmt = $this->conn->prepare("SELECT * FROM pagination WHERE userid = ?");
  $stmt->bind_param("s", $uid);
  $stmt->execute();
  $user = $stmt->get_result()->fetch_assoc();
  $stmt->close();
  return $user;
}
}

 ?>
