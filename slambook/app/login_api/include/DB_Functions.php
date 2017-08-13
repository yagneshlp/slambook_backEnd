<?php



class DB_Functions {

    private $conn;

    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }

    // destructor
    function __destruct() {

    }

    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $email, $password) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
        $verifyhash = md5( rand(0,1000) );
        $stmt = $this->conn->prepare("INSERT INTO users(unique_id, name, email, encrypted_password, salt, created_at,hash) VALUES(?, ?, ?, ?, ?, NOW(),?)");
        $stmt->bind_param("ssssss", $uuid, $name, $email, $encrypted_password, $salt,$verifyhash);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $user;
        } else {
            return false;
        }
    }

    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($email, $password) {

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");

        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            // verifying user password
            $salt = $user['salt'];
            $encrypted_password = $user['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $user;
            }
        } else {
            return NULL;
        }
    }

    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT email from users WHERE email = ?");

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

    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }

    public function set_activated($userid,$uname,$val)
    {
        $conn = new mysqli("mysql.hostinger.in", "u942671737_yagns","randomMonkey5","u942671737_slam");
        $stmt = $conn->prepare("INSERT INTO u942671737_slam.pagination(userid,user_name,activated) VALUES( ?, ?, ?)");
        $stmt->bind_param("sss", $userid,$uname,$val);
        $result=$stmt->execute();
        $stmt->close();
        if ($result) {
            $stmt = $conn->prepare("SELECT * FROM u942671737_slam.pagination WHERE userid = ?");
            $stmt->bind_param("s", $userid);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return true;
        } else {
            return false;
        }

    }
    public function isUserActivated($userid)
    {
        $conn = new mysqli("mysql.hostinger.in", "u942671737_yagns","randomMonkey5","u942671737_slam");
            $stmt = $conn->prepare("SELECT * FROM u942671737_slam.pagination WHERE userid = ?");
            $stmt->bind_param("s", $userid);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if($user["activated"]=="Yes")
                return true;
            else
                return false;

    }

    public function set_progress($userid,$uname,$val)
    {
        $conn = new mysqli("mysql.hostinger.in", "u942671737_yagns","randomMonkey5","u942671737_slam");
        $stmt = $conn->prepare("INSERT INTO u942671737_slam.client_status(userid,user_name,progress) VALUES( ?, ?, ?)");
        $stmt->bind_param("sss", $userid,$uname,$val);
        $result=$stmt->execute();
        $stmt->close();
        if ($result) {
            $stmt = $conn->prepare("SELECT * FROM u942671737_slam.client_status WHERE userid = ?");
            $stmt->bind_param("s", $userid);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return true;
        } else {
            return false;
        }

    }

}

?>
