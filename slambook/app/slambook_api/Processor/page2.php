<?php
class page2
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
  public function storeUser($userid,$username,$ph1,$ph2,$phw,$email)
  {
    $stmt = $this->conn->prepare("INSERT INTO page2(userid,user_name,phone_number_PRIMARY,phone_number_SECONDARY,phone_number_WHATSAPP,email_id) VALUES( ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss",$userid,$username,$ph1,$ph2,$phw,$email);
    $result = $stmt->execute();
    $stmt->close();
    if ($result) {
        $stmt = $this->conn->prepare("SELECT * FROM page2 WHERE userid = ?");
        $stmt->bind_param("s", $userid);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $user;
    } else {
        return false;
    }
  }
  public function updateuser($userid,$username,$ph1,$ph2,$phw,$email)
  {
    $stmt= $this->conn->prepare("UPDATE page2 SET phone_number_PRIMARY =?,phone_number_SECONDARY=?,phone_number_WHATSAPP = ?, email_id = ? where userid= ?");
    $stmt->bind_param("sssss",$ph1,$ph2,$phw,$email,$userid);
    $result = $stmt->execute();
    $stmt->close();
    if ($result) {
        $stmt = $this->conn->prepare("SELECT * FROM page2 WHERE userid = ?");
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
      $stmt = $this->conn->prepare("SELECT userid from page2 WHERE userid = ?");
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
   $stmt = $this->conn->prepare("UPDATE pagination SET page2=? WHERE userid=?");
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
