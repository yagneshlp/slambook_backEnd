<?php
class page4
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

public function retPageStat($uid)
  {
    $stmt = $this->conn->prepare("SELECT * FROM pagination WHERE userid = ?");
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $user;
  }
  public function retPageStatSpl($uname)
    {
      $stmt = $this->conn->prepare("SELECT * FROM pagination WHERE user_name = ?");
      $stmt->bind_param("s", $uname);
      $stmt->execute();
      $user = $stmt->get_result()->fetch_assoc();
      $stmt->close();
      return $user;
    }
  public function setPageStat($uid,$uname)
  {
   $val="Yes";
   $stmt = $this->conn->prepare("UPDATE pagination SET page4=? WHERE userid=?");
   $stmt->bind_param("ss",$val,$uid);
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
  public function setPageStatSpl($uname)
  {
   $val="Yes";
   $stmt = $this->conn->prepare("UPDATE pagination SET page4=? WHERE user_name=?");
   $stmt->bind_param("ss",$val,$uname);
   $result = $stmt->execute();
   $stmt->close();
   if ($result) {
       $stmt = $this->conn->prepare("SELECT * FROM pagination WHERE user_name = ?");
       $stmt->bind_param("s", $uname);
       $stmt->execute();
       $user = $stmt->get_result()->fetch_assoc();
       $stmt->close();
       return $user;
   } else {
       return false;
   }
  }
}
?>
