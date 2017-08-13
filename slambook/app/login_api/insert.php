<?php
require_once 'process/manager.php';
$db=new manager();
$response = array('error' => false);
$response = array('message' => "null");

if(isset($_POST['name']) && isset($_POST['nickname']) && isset($_POST['dob']))
  {
      $name=$_POST['name'];
      $nickname = $_POST['nickname'];
      $dob = $_POST['dob'];

      if ($db->isUserExisted($name))
      {
          $user = $db->updateuser($name,$nickname,$dob);
          if($user)
          {
            $response["error"] = FALSE;
            $response["message"] = "user was already existed. so entry updated";

          }
          else {
            $response["error"] = TRUE;
            $response["message"] = "user not inserted";
          }
          echo json_encode($response);
      }
      else {
         $user= $db->storeuser($name,$nickname,$dob);
         if($user)
         {
           $response["error"] = FALSE;
           $response["message"] = "first time user submitted, so new entry created";
         }
         else {
           $response["error"] = TRUE;
           $response["message"] = "user not inserted";
         }

         echo json_encode($response);

      }
  }
  else {
    $response["error"] = TRUE;
    $response["message"] = "Either of the parameters is missing, try again";
    echo json_encode($response);
  }
 ?>
