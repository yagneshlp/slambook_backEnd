
<?php
class page30
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
    $stmt = $this->conn->prepare("SELECT userid from client_status WHERE userid = ?");
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

 public function updateprogress($uid,$uname,$val)
{
  $stmt= $this->conn->prepare("UPDATE client_status SET progress= progress+? where userid= ?");
  $stmt->bind_param("ss",$val,$uid);
  $result = $stmt->execute();
  $stmt->close();
  if ($result) {
      $stmt = $this->conn->prepare("SELECT * FROM client_status WHERE userid = ?");
      $stmt->bind_param("s", $uid);
      $stmt->execute();
      $user = $stmt->get_result()->fetch_assoc();
      $stmt->close();
      return $user;
  } else {
      return false;
  }
}

  public  function updatelogin($uid,$uname,$val)
{
  $stmt= $this->conn->prepare("UPDATE client_status SET last_login=? where userid= ?");
  $stmt->bind_param("ss",$val,$uid);
  $result = $stmt->execute();
  $stmt->close();
  if ($result) {
      $stmt = $this->conn->prepare("SELECT * FROM client_status WHERE userid = ?");
      $stmt->bind_param("s", $uid);
      $stmt->execute();
      $user = $stmt->get_result()->fetch_assoc();
      $stmt->close();
      return $user;
  } else {
      return false;
  }
}
  public  function updatereminder($uid,$uname,$val)
{
  $stmt= $this->conn->prepare("UPDATE client_status SET reminderIfSet_time=? where userid= ?");
  $stmt->bind_param("ss",$val,$uid);
  $result = $stmt->execute();
  $stmt->close();
  if ($result) {
      $stmt = $this->conn->prepare("SELECT * FROM client_status WHERE userid = ?");
      $stmt->bind_param("s", $uid);
      $stmt->execute();
      $user = $stmt->get_result()->fetch_assoc();
      $stmt->close();
      return $user;
  } else {
      return false;
  }
}
  public function updateAttn($uid,$uname,$val)
{
  $stmt= $this->conn->prepare("UPDATE client_status SET requireATTENTION=? where userid= ?");
  $stmt->bind_param("ss",$val,$uid);
  $result = $stmt->execute();
  $stmt->close();
  if ($result) {
      $stmt = $this->conn->prepare("SELECT * FROM client_status WHERE userid = ?");
      $stmt->bind_param("s", $uid);
      $stmt->execute();
      $user = $stmt->get_result()->fetch_assoc();
      $stmt->close();
      return $user;
  } else {
      return false;
  }
}

 public function storeprogress($uid,$uname,$val)
{
  $stmt = $this->conn->prepare("INSERT INTO client_status(userid,user_name,progress) VALUES( ?, ?, ?)");
  $stmt->bind_param("sss",$uid,$uname,$val);
  $result = $stmt->execute();
  $stmt->close();
  if ($result) {
      $stmt = $this->conn->prepare("SELECT * FROM client_status WHERE userid = ?");
      $stmt->bind_param("s", $uid);
      $stmt->execute();
      $user = $stmt->get_result()->fetch_assoc();
      $stmt->close();
      return $user;
  } else {
      return false;
  }
}
  public function storelogin($uid,$uname,$val)
{
  $stmt = $this->conn->prepare("INSERT INTO client_status(userid,user_name,lastLogin) VALUES( ?, ?, ?)");
  $stmt->bind_param("sss",$uid,$uname,$val);
  $result = $stmt->execute();
  $stmt->close();
  if ($result) {
      $stmt = $this->conn->prepare("SELECT * FROM client_status WHERE userid = ?");
      $stmt->bind_param("s", $uid);
      $stmt->execute();
      $user = $stmt->get_result()->fetch_assoc();
      $stmt->close();
      return $user;
  } else {
      return false;
  }
}
  public function storereminder($uid,$uname,$val)
{
  $stmt = $this->conn->prepare("INSERT INTO client_status(userid,user_name,reminderIfSet_time) VALUES( ?, ?, ?)");
  $stmt->bind_param("sss",$uid,$uname,$val);
  $result = $stmt->execute();
  $stmt->close();
  if ($result) {
      $stmt = $this->conn->prepare("SELECT * FROM client_status WHERE userid = ?");
      $stmt->bind_param("s", $uid);
      $stmt->execute();
      $user = $stmt->get_result()->fetch_assoc();
      $stmt->close();
      return $user;
  } else {
      return false;
  }
}
  public function storeAttn($uid,$uname,$val)
{
  $stmt = $this->conn->prepare("INSERT INTO client_status(userid,user_name,requireATTENTION) VALUES( ?, ?, ?)");
  $stmt->bind_param("sss",$uid,$uname,$val);
  $result = $stmt->execute();
  $stmt->close();
  if ($result) {
      $stmt = $this->conn->prepare("SELECT * FROM client_status WHERE userid = ?");
      $stmt->bind_param("s", $uid);
      $stmt->execute();
      $user = $stmt->get_result()->fetch_assoc();
      $stmt->close();
      return $user;
  } else {
      return false;
  }
}

  public function returninfo($uid,$uname,$val)
{
  $stmt = $this->conn->prepare("SELECT * FROM client_status WHERE userid = ?");
  $stmt->bind_param("s", $uid);
  $stmt->execute();
  $user = $stmt->get_result()->fetch_assoc();
  $stmt->close();
  return $user;
}

}

 ?>
