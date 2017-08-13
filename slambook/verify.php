<?php

          require_once 'verification/include/DB_Connect.php';
          $db = new DB_Connect();
          $conn = $db->connect();
          if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']))
          {
              $email =$_GET['email']; // Set email variable
              $hash = $_GET['hash']; // Set hash variable
              $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND hash = ?");
              $stmt->bind_param("ss", $email,$hash);
              $stmt->execute();
              $user = $stmt->get_result()->fetch_assoc();
              $stmt->close();
              $val="Yes";
              $connection = new mysqli("mysql.hostinger.in", "u942671737_yagns","randomMonkey5","u942671737_slam");
              $stmt = $connection->prepare("UPDATE u942671737_slam.pagination SET activated = ? WHERE userid = ?");
              $stmt->bind_param("ss",$val,$user["id"]);
              $result=$stmt->execute();
              $stmt->close();
              if($result)
              {
               header('Location: /verification');
              }
              else {
                //display failed
              }
          }
          else{
                // Invalid approach
            }

       ?>
