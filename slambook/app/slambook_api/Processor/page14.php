<?php
class page14
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
  public function storeUser($userid,$username,$hol,$reason)
  {
    $stmt = $this->conn->prepare("INSERT INTO page14(userid,user_name,holiday,reason) VALUES(?, ?, ?, ?)");
    $stmt->bind_param("ssss",$userid,$username,$hol,$reason);
    $result = $stmt->execute();
    $stmt->close();
    if ($result) {
        $stmt = $this->conn->prepare("SELECT * FROM page14 WHERE userid = ?");
        $stmt->bind_param("s", $userid);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $user;
    } else {
        return false;
    }
  }
  public function updateuser($userid,$username,$hol,$reason)
  {
    $stmt= $this->conn->prepare("UPDATE page14 SET holiday=?,reason=? where userid= ?");
    $stmt->bind_param("sss",$hol,$reason,$userid);
    $result = $stmt->execute();
    $stmt->close();
    if ($result) {
        $stmt = $this->conn->prepare("SELECT * FROM page14 WHERE userid = ?");
        $stmt->bind_param("s", $userid);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $user;
    } else {
        return false;
    }

  }
  public function isUserExisted($userid)
   {
      $stmt = $this->conn->prepare("SELECT userid from page14 WHERE userid = ?");
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
  public function retPageStat($uid)
  {
    $stmt = $this->conn->prepare("SELECT * FROM pagination WHERE userid = ?");
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $user;
  }
  public function setPageStat($uid,$uname)
  {
   $val="Yes";
   $stmt = $this->conn->prepare("UPDATE pagination SET page14=? WHERE userid=?");
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
}
?>
