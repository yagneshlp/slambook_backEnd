<?php
class page3
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
  public function storeUser($userid,$username,$fb,$tw,$gp,$ig,$pin,$quo)
  {
    $stmt = $this->conn->prepare("INSERT INTO page3(userid,user_name,facebook_uname,twitter_uname,googlePlus_uname,instagram_uname,pintrest_uname,quora_uname) VALUES( ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss",$userid,$username,$fb,$tw,$gp,$ig,$pin,$quo);
    $result = $stmt->execute();
    $stmt->close();
    if ($result) {
        $stmt = $this->conn->prepare("SELECT * FROM page3 WHERE userid = ?");
        $stmt->bind_param("s", $userid);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $user;
    } else {
        return false;
    }
  }
  public function updateuser($userid,$username,$fb,$tw,$gp,$ig,$pin,$quo)
  {
    $stmt= $this->conn->prepare("UPDATE page3 SET facebook_uname=?,twitter_uname=?,googlePlus_uname=?,instagram_uname=?,pintrest_uname=?,quora_uname=? where userid= ?");
    $stmt->bind_param("sssssss",$fb,$tw,$gp,$ig,$pin,$quo,$userid);
    $result = $stmt->execute();
    $stmt->close();
    if ($result) {
        $stmt = $this->conn->prepare("SELECT * FROM page3 WHERE userid = ?");
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
      $stmt = $this->conn->prepare("SELECT userid from page3 WHERE userid = ?");
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
   $stmt = $this->conn->prepare("UPDATE pagination SET page3=? WHERE userid=?");
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
