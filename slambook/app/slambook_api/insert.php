<?php

$response = array('error' => TRUE);
$response = array('message' => "null");

$route=$_POST['route'];
switch($route)
{
  case "1":  //Coding not complete, TODO: finish it
  {
        require_once 'Processor/page1.php'; //required file, contains all the methods for the insertion/updating data
        require_once 'Processor/page30.php'; //included for the methodsit offers to update the progress percentage
        $db=new page1();
        if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['full_name']) && isset($_POST['nickname']) && isset($_POST['dob'])) // checking if the user intended to insert or update the data or he wants the current page status by seing what he sent in json
          {
              $userid=$_POST['userid'];
              $username=$_POST['username'];
              $name=$_POST['full_name'];
              $nickname = $_POST['nickname'];
              $dob = $_POST['dob'];
              global $flag;
              $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
              if($dum['page1']=='Yes')
                $flag=1; //the particular page is already existant because this time was re filled
              else
                $flag=0;     //the particular page is being fille dfor the first time

              if ($db->isUserExisted($userid))  //if the user's data is not being entered for the first time
              {
                  $user = $db->updateuser($userid,$username,$name,$nickname,$dob);
                  if($user) //the user's data has been successfully filled
                  {
                    if($flag==0) //the particular page is being filled for the first time
                      {
                        $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                        $prog=new page30();
                        $val=5; //the value point for completion of the page
                        $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                        $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                      }
                      else if($flag==1) //the particular page is already existant because this time was re filled
                      {
                        $prog=new page30();
                        $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                        $response["progress"] = $dump["progress"]; //binding progress value with json
                      }

                    $response["error"] = FALSE;           //since successfully the user's data was inserted/updated, no error
                    $response["message"] = "Record  already existed. so entry updated";

                  }
                  else { //data wasnt inserted properly, error
                    $response["error"] = TRUE; //setting the value of error to be true
                    $response["message"] = "Record  was tried to update, not updated";
                  }
                  echo json_encode($response);
              }
              else {  //if the user's data is being entered for the first time

                 $user= $db->storeuser($userid,$username,$name,$nickname,$dob); //since first time, value is being inserted
                 if($user) //useer data successfully inserted
                 {
                     if($flag==0) //the particular page is being filled for the first time
                     {
                       $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                       $prog=new page30();
                       $val=5; //the value point for completion of the page
                       $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                       $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                     }
                     else if($flag==1) //the particular page is already existant because this time was re filled
                     {
                       $prog=new page30();
                       $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                       $response["progress"] = $dump["progress"]; //binding progress value with json
                       }
                   $response["error"] = FALSE;  //no error since user has been succesfull inserted
                   $response["message"] = "first time Record submitted, so new entry created"; //message
                 }
                 else { //user data not entered
                   $response["error"] = TRUE;
                   $response["message"] = "Record was tried to insert, not inserted";
                 }
                 echo json_encode($response);

              }
          }
            else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
            {
            $userid=$_POST['userid'];
            $username=$_POST['username'];
            $need=$_POST['need'];
            if($need=='get')
            {
              $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
              if($dum)
                $response['value']=$dum['page1'];
              else
                $response['value']="No";

              $response["error"] = FALSE;
              $response["message"] = "Value of requested param is returned";
              echo json_encode($response);
            }
          }
          else
          {
            $response["error"] = TRUE;
            $response["message"] = "Either of the parameters is missing, try again";
            echo json_encode($response);
          }
        break;
      }
  case 2:
  {
        require_once 'Processor/page2.php';
        require_once 'Processor/page30.php'; //included for the methodsit offers to update the progress percentage
        $db=new page2();
        if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['ph1']) && isset($_POST['ph2']) && isset($_POST['phw']) && isset($_POST['email']))
        {
          $userid=$_POST['userid'];
          $username=$_POST['username'];
          $ph1=$_POST['ph1'];
          $ph2=$_POST['ph2'];
          $phw=$_POST['phw'];
          $email=$_POST['email'];
          global $flag;
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum['page2']=='Yes')
            $flag=1; //the particular page is already existant because this time was re filled
          else
            $flag=0;     //the particular page is being fille dfor the first time

          if ($db->isUserExisted($userid))
          {
              $user = $db->updateuser($userid,$username,$ph1,$ph2,$phw,$email);
              if($user)
              {
                if($flag==0) //the particular page is being filled for the first time
                  {
                    $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                    $prog=new page30();
                    $val=5; //the value point for completion of the page
                    $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                    $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                  }
                  else if($flag==1) //the particular page is already existant because this time was re filled
                  {
                    $prog=new page30();
                    $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                    $response["progress"] = $dump["progress"]; //binding progress value with json
                  }
                $response["error"] = FALSE;
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          else {
             $user= $db->storeuser($userid,$username,$ph1,$ph2,$phw,$email);
             if($user)
             {
               if($flag==0) //the particular page is being filled for the first time
                 {
                   $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                   $prog=new page30();
                   $val=5; //the value point for completion of the page
                   $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                   $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                 }
                 else if($flag==1) //the particular page is already existant because this time was re filled
                 {
                   $prog=new page30();
                   $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                   $response["progress"] = $dump["progress"]; //binding progress value with json
                 }
               $response["error"] = FALSE;
               $response["message"] = "first time Record submitted, so new entry created";
             }
             else {
               $response["error"] = TRUE;
               $response["message"] = "Record was tried to insert, not inserted";
             }

             echo json_encode($response);
        }}
        else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
        {
          $userid=$_POST['userid'];
          $username=$_POST['username'];
          $need=$_POST['need'];
          if($need=='get')
          {
            $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
            if($dum)
              $response['value']=$dum['page2'];
            else
             $response['value']="No";

            $response["error"] = FALSE;
            $response["message"] = "Value of requested param is returned";
            echo json_encode($response);
          }
        }
        else
        {
          $response["error"] = TRUE;
          $response["message"] = "Either of the parameters is missing, try again";
          echo json_encode($response);
        }
        break;
      }
  case 3:
  {
       require_once 'Processor/page3.php';
       require_once 'Processor/page30.php'; //included for the methodsit offers to update the progress percentage
       $db=new page3();
       if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['fb']) && isset($_POST['tw']) && isset($_POST['gp']) && isset($_POST['ig']) && isset($_POST['pin']) && isset($_POST['quo']))
       {
         $userid=$_POST['userid'];
         $username=$_POST['username'];
         $fb=$_POST['fb'];
         $tw=$_POST['tw'];
         $gp=$_POST['gp'];
         $ig=$_POST['ig'];
         $pin=$_POST['pin'];
         $quo=$_POST['quo'];
         global $flag;
         $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
         if($dum['page3']=='Yes')
           $flag=1; //the particular page is already existant because this time was re filled
         else
           $flag=0;     //the particular page is being fille dfor the first time

         if ($db->isUserExisted($userid))
         {
             $user = $db->updateuser($userid,$username,$fb,$tw,$gp,$ig,$pin,$quo);
             if($user)
             {
               if($flag==0) //the particular page is being filled for the first time
                 {
                   $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                   $prog=new page30();
                   $val=5; //the value point for completion of the page
                   $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                   $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                 }
                 else if($flag==1) //the particular page is already existant because this time was re filled
                 {
                   $prog=new page30();
                   $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                   $response["progress"] = $dump["progress"]; //binding progress value with json
                 }
                 else {
                   $response["error"] = TRUE;
                   $response["message"] = "Record  was tried to update, not updated";
                   echo json_encode($response);
                 }
               $response["error"] = FALSE;
               $response["message"] = "Record  already existed. so entry updated";

             }
             else {
               $response["error"] = TRUE;
               $response["message"] = "Record  was tried to update, not updated";
             }
             echo json_encode($response);
         }
         else {
            $user= $db->storeuser($userid,$username,$fb,$tw,$gp,$ig,$pin,$quo);
            if($user)
            {
              if($flag==0) //the particular page is being filled for the first time
                {
                  $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                  $prog=new page30();
                  $val=5; //the value point for completion of the page
                  $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                  $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                }
                else if($flag==1) //the particular page is already existant because this time was re filled
                {
                  $prog=new page30();
                  $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                  $response["progress"] = $dump["progress"]; //binding progress value with json
                }
              $response["error"] = FALSE;
              $response["message"] = "first time Record submitted, so new entry created";
            }
            else {
              $response["error"] = TRUE;
              $response["message"] = "Record was tried to insert, not inserted";
            }

            echo json_encode($response);
       }}
       else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
       {
         $userid=$_POST['userid'];
         $username=$_POST['username'];
         $need=$_POST['need'];
         if($need=='get')
         {
           $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
           if($dum)
             $response['value']=$dum['page3'];
           else
             $response['value']="No";

           $response["error"] = FALSE;
           $response["message"] = "Value of requested param is returned";
           echo json_encode($response);
         }
       }
       else
       {
         $response["error"] = TRUE;
         $response["message"] = "Either of the parameters is missing, try again";
         echo json_encode($response);
       }
       break;
      }
  case 4:
  {
       require_once 'Processor/page4.php';
       require_once 'Processor/page30.php'; //included for the methodsit offers to update the progress percentage
       $db=new page4();
       if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['dummy']))
       {
         $userid=$_POST['userid'];
         $username=$_POST['username'];
         global $flag;
         $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
         if($dum['page4']=='Yes')
           $flag=1; //the particular page is already existant because this time was re filled
         else
           $flag=0;     //the particular page is being fille dfor the first time

               if($flag==0) //the particular page is being filled for the first time
                 {
                   $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                   $prog=new page30();
                   $val=4; //the value point for completion of the page
                   $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                   $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                 }
                 else if($flag==1) //the particular page is already existant because this time was re filled
                 {
                   $prog=new page30();
                   $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                   $response["progress"] = $dump["progress"]; //binding progress value with json
                 }
                 else {
                   $response["error"] = TRUE;
                   $response["message"] = "global flag does not take value  0 or 1";
                   echo json_encode($response);
                 }
               $response["error"] = FALSE;
               $response["message"] = "profile picture value in pagination changed to yes and progress relayed";


             echo json_encode($response);


       }
        else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
       {
         $userid=$_POST['userid'];
         $username=$_POST['username'];
         $need=$_POST['need'];
         if($need=='get')
         {
           $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
           if($dum)
             $response['value']=$dum['page4'];
           else
             $response['value']="No";

           $response["error"] = FALSE;
           $response["message"] = "Value of requested param is returned";
           echo json_encode($response);
         }
       }
       else
       {
         $response["error"] = TRUE;
         $response["message"] = "Either of the parameters is missing, try again";
         echo json_encode($response);
       }
       break;
      }
  case 5:
  {
    require_once 'Processor/page5.php';
    require_once 'Processor/page30.php'; //included for the methodsit offers to update the progress percentage
    $db=new page5();
    if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['address']) )
      {
          $userid=$_POST['userid'];
          $username=$_POST['username'];
          $address=$_POST['address'];
          global $flag;
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum['page5']=='Yes')
                $flag=1; //the particular page is already existant because this time was re filled
            else
               $flag=0;

          if ($db->isUserExisted($userid))
          {
              $user = $db->updateuser($userid,$username,$address);
              if($user)
              {
                       if($flag==0) //the particular page is being filled for the first time
                                {
                                  $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                                  $prog=new page30();
                                  $val=4; //the value point for completion of the page
                                  $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                         $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                                }
                                else if($flag==1) //the particular page is already existant because this time was re filled
                                {
                                  $prog=new page30();
                                  $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                                  $response["progress"] = $dump["progress"]; //binding progress value with json
                                }

                $response["error"] = FALSE;
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          else {
             $user= $db->storeuser($userid,$username,$address);
             if($user)
             {
               if($flag==0) //the particular page is being filled for the first time
                                  {
                                    $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                                    $prog=new page30();
                                    $val=4; //the value point for completion of the page
                                    $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                                    $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                                  }
                                  else if($flag==1) //the particular page is already existant because this time was re filled
                                  {
                                    $prog=new page30();
                                    $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                                    $response["progress"] = $dump["progress"]; //binding progress value with json

               $response["error"] = FALSE;
               $response["message"] = "first time Record submitted, so new entry created";
             }}
             else {
               $response["error"] = TRUE;
               $response["message"] = "Record was tried to insert, not inserted";
             }

             echo json_encode($response);

          }
      }
      else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
      /* copy this line*/          {
                $userid=$_POST['userid'];
                $username=$_POST['username'];
                $need=$_POST['need'];
                if($need=='get')
                {
                  $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
                  if($dum)
                    $response['value']=$dum['page5'];
                  else
                    $response['value']="No";

                  $response["error"] = FALSE;
                  $response["message"] = "Value of requested param is returned";
                  echo json_encode($response);
                }
              }
      else
      {
        $response["error"] = TRUE;
        $response["message"] = "Either of the parameters is missing, try again";
        echo json_encode($response);
      }
    break;
  }
  case 6:
  {
    require_once 'Processor/page6.php';
    require_once 'Processor/page30.php';
    $db=new page6();
    if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['selfDesc']) )
      {
          $userid=$_POST['userid'];
          $username=$_POST['username'];
          $selfDesc=$_POST['selfDesc'];
          global $flag;
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum['page6']=='Yes')
            $flag=1; //the particular page is already existant because this time was re filled
          else
            $flag=0;

          if ($db->isUserExisted($userid))
          {
              $user = $db->updateuser($userid,$username,$selfDesc);
              if($user)
              {
                if($flag==0) //the particular page is being filled for the first time
                  {
                    $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                    $prog=new page30();
                    $val=4; //the value point for completion of the page
                    $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                       $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it

                  }
                  else if($flag==1) //the particular page is already existant because this time was re filled
                  {
                    $prog=new page30();
                    $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                    $response["progress"] = $dump["progress"]; //binding progress value with json
                  }
                $response["error"] = FALSE;
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          else {
             $user= $db->storeuser($userid,$username,$selfDesc);
             if($user)
             {
               if($flag==0) //the particular page is being filled for the first time
                 {
                   $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                   $prog=new page30();
                   $val=4; //the value point for completion of the page
                   $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                   $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                 }
                 else if($flag==1) //the particular page is already existant because this time was re filled
                 {
                   $prog=new page30();
                   $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                   $response["progress"] = $dump["progress"]; //binding progress value with json
                 }
               $response["error"] = FALSE;
               $response["message"] = "first time Record submitted, so new entry created";
             }
             else {
               $response["error"] = TRUE;
               $response["message"] = "Record was tried to insert, not inserted";
             }

             echo json_encode($response);

          }
      }
      else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
      {
        $userid=$_POST['userid'];
        $username=$_POST['username'];
        $need=$_POST['need'];
        if($need=='get')
        {
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum)
            $response['value']=$dum['page6'];
          else
           $response['value']="No";

          $response["error"] = FALSE;
          $response["message"] = "Value of requested param is returned";
          echo json_encode($response);
        }
      }
      else
      {
        $response["error"] = TRUE;
        $response["message"] = "Either of the parameters is missing, try again";
        echo json_encode($response);
      }
    break;
  }
  case 7:
  {
    require_once 'Processor/page7.php';
    require_once 'Processor/page30.php';
    $db=new page7();
    if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['smile']) && isset($_POST['food']) )
      {
          $userid=$_POST['userid'];
          $username=$_POST['username'];
          $smile=$_POST['smile'];
          $food=$_POST['food'];
          global $flag;
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum['page7']=='Yes')
            $flag=1; //the particular page is already existant because this time was re filled
          else
            $flag=0;     //the particular page is being fille dfor the first time

          if ($db->isUserExisted($userid))
          {
              $user = $db->updateuser($userid,$username,$smile,$food);
              if($user)
              {
                if($flag==0) //the particular page is being filled for the first time
                  {
                    $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                    $prog=new page30();
                    $val=3; //the value point for completion of the page
                    $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                    $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                  }
                  else if($flag==1) //the particular page is already existant because this time was re filled
                  {
                    $prog=new page30();
                    $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                    $response["progress"] = $dump["progress"]; //binding progress value with json
                  }
                $response["error"] = FALSE;
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          else {
             $user= $db->storeuser($userid,$username,$smile,$food);
             if($user)
             {
               if($flag==0) //the particular page is being filled for the first time
                 {
                   $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                   $prog=new page30();
                   $val=3; //the value point for completion of the page
                   $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                   $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                 }
                 else if($flag==1) //the particular page is already existant because this time was re filled
                 {
                   $prog=new page30();
                   $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                   $response["progress"] = $dump["progress"]; //binding progress value with json
                 }
               $response["error"] = FALSE;
               $response["message"] = "first time Record submitted, so new entry created";
             }
             else {
               $response["error"] = TRUE;
               $response["message"] = "Record was tried to insert, not inserted";
             }

             echo json_encode($response);

          }
      }
      else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
      {
        $userid=$_POST['userid'];
        $username=$_POST['username'];
        $need=$_POST['need'];
        if($need=='get')
        {
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum)
            $response['value']=$dum['page7'];
          else
           $response['value']="No";

          $response["error"] = FALSE;
          $response["message"] = "Value of requested param is returned";
          echo json_encode($response);
        }
      }
      else
      {
        $response["error"] = TRUE;
        $response["message"] = "Either of the parameters is missing, try again";
        echo json_encode($response);
      }
    break;
  }
  case 8:
  {
    require_once 'Processor/page8.php';
    require_once 'Processor/page30.php';
    $db=new page8();
    if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['song']) && isset($_POST['artist']) && isset($_POST['playlist']) )
      {
          $userid=$_POST['userid'];
          $username=$_POST['username'];
          $song=$_POST['song'];
          $artist=$_POST['artist'];
          $playlist=$_POST['playlist'];
          global $flag;
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum['page8']=='Yes')
            $flag=1; //the particular page is already existant because this time was re filled
          else
            $flag=0;     //the particular page is being fille dfor the first time

          if ($db->isUserExisted($userid))
          {
              $user = $db->updateuser($userid,$username,$song,$artist,$playlist);
              if($user)
              {
                if($flag==0) //the particular page is being filled for the first time
                  {
                    $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                    $prog=new page30();
                    $val=5; //the value point for completion of the page
                    $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                    $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                  }
                  else if($flag==1) //the particular page is already existant because this time was re filled
                  {
                    $prog=new page30();
                    $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                    $response["progress"] = $dump["progress"]; //binding progress value with json
                  }
                $response["error"] = FALSE;
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          else {
             $user= $db->storeuser($userid,$username,$song,$artist,$playlist);
             if($user)
             {
               if($flag==0) //the particular page is being filled for the first time
                 {
                   $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                   $prog=new page30();
                   $val=5; //the value point for completion of the page
                   $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                   $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                 }
                 else if($flag==1) //the particular page is already existant because this time was re filled
                 {
                   $prog=new page30();
                   $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                   $response["progress"] = $dump["progress"]; //binding progress value with json
                 }
               $response["error"] = FALSE;
               $response["message"] = "first time Record submitted, so new entry created";
             }
             else {
               $response["error"] = TRUE;
               $response["message"] = "Record was tried to insert, not inserted";
             }

             echo json_encode($response);

          }
      }
      else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
      {
        $userid=$_POST['userid'];
        $username=$_POST['username'];
        $need=$_POST['need'];
        if($need=='get')
        {
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum)
            $response['value']=$dum['page8'];
          else
           $response['value']="No";

          $response["error"] = FALSE;
          $response["message"] = "Value of requested param is returned";
          echo json_encode($response);
        }
      }
      else
      {
        $response["error"] = TRUE;
        $response["message"] = "Either of the parameters is missing, try again";
        echo json_encode($response);
      }
    break;
  }
  case 9:
  {
    require_once 'Processor/page9.php';
    require_once 'Processor/page30.php';
    $db=new page9();
    if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['bff']) && isset($_POST['stuff']) )
      {
          $userid=$_POST['userid'];
          $username=$_POST['username'];
          $bff=$_POST['bff'];
          $stuff=$_POST['stuff'];
          global $flag;
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum['page9']=='Yes')
            $flag=1; //the particular page is already existant because this time was re filled
          else
            $flag=0;     //the particular page is being fille dfor the first time


          if ($db->isUserExisted($userid))
          {
              $user = $db->updateuser($userid,$username,$bff,$stuff);
              if($user)
              {
                if($flag==0) //the particular page is being filled for the first time
                  {
                    $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                    $prog=new page30();
                    $val=5; //the value point for completion of the page
                    $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                    $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                  }
                  else if($flag==1) //the particular page is already existant because this time was re filled
                  {
                    $prog=new page30();
                    $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                    $response["progress"] = $dump["progress"]; //binding progress value with json
                  }
                $response["error"] = FALSE;
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          else {
             $user= $db->storeuser($userid,$username,$bff,$stuff);
             if($user)
             {
               if($flag==0) //the particular page is being filled for the first time
                 {
                   $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                   $prog=new page30();
                   $val=5; //the value point for completion of the page
                   $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                   $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                 }
                 else if($flag==1) //the particular page is already existant because this time was re filled
                 {
                   $prog=new page30();
                   $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                   $response["progress"] = $dump["progress"]; //binding progress value with json
                 }
               $response["error"] = FALSE;
               $response["message"] = "first time Record submitted, so new entry created";
             }
             else {
               $response["error"] = TRUE;
               $response["message"] = "Record was tried to insert, not inserted";
             }

             echo json_encode($response);

          }
      }
      else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
      {
        $userid=$_POST['userid'];
        $username=$_POST['username'];
        $need=$_POST['need'];
        if($need=='get')
        {
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum)
            $response['value']=$dum['page9'];
          else
           $response['value']="No";

          $response["error"] = FALSE;
          $response["message"] = "Value of requested param is returned";
          echo json_encode($response);
        }
      }
      else
      {
        $response["error"] = TRUE;
        $response["message"] = "Either of the parameters is missing, try again";
        echo json_encode($response);
      }
    break;
  }
  case 10:
  {
    require_once 'Processor/page10.php';
    require_once 'Processor/page30.php';
    $db=new page10();
    if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['moviet']) && isset($_POST['movier']) )
      {
          $userid=$_POST['userid'];
          $username=$_POST['username'];
          $movt=$_POST['moviet'];
          $movr=$_POST['movier'];
          global $flag;
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum['page10']=='Yes')
            $flag=1; //the particular page is already existant because this time was re filled
          else
            $flag=0;     //the particular page is being fille dfor the first time

          if ($db->isUserExisted($userid))
          {
              $user = $db->updateuser($userid,$username,$movt,$movr);
              if($user)
              {
                if($flag==0) //the particular page is being filled for the first time
                  {
                    $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                    $prog=new page30();
                    $val=5; //the value point for completion of the page
                    $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                    $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                  }
                  else if($flag==1) //the particular page is already existant because this time was re filled
                  {
                    $prog=new page30();
                    $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                    $response["progress"] = $dump["progress"]; //binding progress value with json
                  }
                $response["error"] = FALSE;
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          else {
             $user= $db->storeuser($userid,$username,$movt,$movr);
             if($user)
             {
               if($flag==0) //the particular page is being filled for the first time
                 {
                   $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                   $prog=new page30();
                   $val=5; //the value point for completion of the page
                   $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                   $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                 }
                 else if($flag==1) //the particular page is already existant because this time was re filled
                 {
                   $prog=new page30();
                   $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                   $response["progress"] = $dump["progress"]; //binding progress value with json
                 }
               $response["error"] = FALSE;
               $response["message"] = "first time Record submitted, so new entry created";
             }
             else {
               $response["error"] = TRUE;
               $response["message"] = "Record was tried to insert, not inserted";
             }

             echo json_encode($response);

          }
      }
      else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
      {
        $userid=$_POST['userid'];
        $username=$_POST['username'];
        $need=$_POST['need'];
        if($need=='get')
        {
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum)
            $response['value']=$dum['page10'];
          else
           $response['value']="No";

          $response["error"] = FALSE;
          $response["message"] = "Value of requested param is returned";
          echo json_encode($response);
        }
      }
      else
      {
        $response["error"] = TRUE;
        $response["message"] = "Either of the parameters is missing, try again";
        echo json_encode($response);
      }
    break;
  }
  case 11:
  {
    require_once 'Processor/page11.php';
    require_once 'Processor/page30.php';
    $db=new page11();
    if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['tv']) )
      {
          $userid=$_POST['userid'];
          $username=$_POST['username'];
          $tv=$_POST['tv'];
          global $flag;
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum['page11']=='Yes')
            $flag=1; //the particular page is already existant because this time was re filled
          else
            $flag=0;     //the particular page is being fille dfor the first time

          if ($db->isUserExisted($userid))
          {
              $user = $db->updateuser($userid,$username,$tv);
              if($user)
              {
                if($flag==0) //the particular page is being filled for the first time
                  {
                    $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                    $prog=new page30();
                    $val=4; //the value point for completion of the page
                    $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                    $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                  }
                  else if($flag==1) //the particular page is already existant because this time was re filled
                  {
                    $prog=new page30();
                    $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                    $response["progress"] = $dump["progress"]; //binding progress value with json
                  }
                $response["error"] = FALSE;
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          else {
             $user= $db->storeuser($userid,$username,$tv);
             if($user)
             {
               if($flag==0) //the particular page is being filled for the first time
                 {
                   $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                   $prog=new page30();
                   $val=4; //the value point for completion of the page
                   $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                   $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                 }
                 else if($flag==1) //the particular page is already existant because this time was re filled
                 {
                   $prog=new page30();
                   $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                   $response["progress"] = $dump["progress"]; //binding progress value with json
                 }
               $response["error"] = FALSE;
               $response["message"] = "first time Record submitted, so new entry created";
             }
             else {
               $response["error"] = TRUE;
               $response["message"] = "Record was tried to insert, not inserted";
             }

             echo json_encode($response);

          }
      }
      else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
      {
        $userid=$_POST['userid'];
        $username=$_POST['username'];
        $need=$_POST['need'];
        if($need=='get')
        {
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum)
            $response['value']=$dum['page11'];
          else
            $response['value']="No";

          $response["error"] = FALSE;
          $response["message"] = "Value of requested param is returned";
          echo json_encode($response);
        }
      }
      else
      {
        $response["error"] = TRUE;
        $response["message"] = "Either of the parameters is missing, try again";
        echo json_encode($response);
      }
    break;
  }
  case 12:
  {
    require_once 'Processor/page12.php';
    require_once 'Processor/page30.php';
    $db=new page12();
    if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['specialt']) && isset($_POST['acquiredt']) )
      {
          $userid=$_POST['userid'];
          $username=$_POST['username'];
          $st=$_POST['specialt'];
          $at=$_POST['acquiredt'];
          global $flag;
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum['page12']=='Yes')
            $flag=1; //the particular page is already existant because this time was re filled
          else
            $flag=0;     //the particular page is being fille dfor the first time

          if ($db->isUserExisted($userid))
          {
              $user = $db->updateuser($userid,$username,$st,$at);
              if($user)
              {
                if($flag==0) //the particular page is being filled for the first time
                  {
                    $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                    $prog=new page30();
                    $val=5; //the value point for completion of the page
                    $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                    $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                  }
                  else if($flag==1) //the particular page is already existant because this time was re filled
                  {
                    $prog=new page30();
                    $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                    $response["progress"] = $dump["progress"]; //binding progress value with json
                  }
                $response["error"] = FALSE;
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          else {
             $user= $db->storeuser($userid,$username,$st,$at);
             if($user)
             {
               if($flag==0) //the particular page is being filled for the first time
                 {
                   $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                   $prog=new page30();
                   $val=5; //the value point for completion of the page
                   $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                   $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                 }
                 else if($flag==1) //the particular page is already existant because this time was re filled
                 {
                   $prog=new page30();
                   $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                   $response["progress"] = $dump["progress"]; //binding progress value with json
                 }
               $response["error"] = FALSE;
               $response["message"] = "first time Record submitted, so new entry created";
             }
             else {
               $response["error"] = TRUE;
               $response["message"] = "Record was tried to insert, not inserted";
             }

             echo json_encode($response);

          }
      }
      else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
      {
        $userid=$_POST['userid'];
        $username=$_POST['username'];
        $need=$_POST['need'];
        if($need=='get')
        {
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum)
            $response['value']=$dum['page12'];
          else
            $response['value']="No";

          $response["error"] = FALSE;
          $response["message"] = "Value of requested param is returned";
          echo json_encode($response);
        }
      }
      else
      {
        $response["error"] = TRUE;
        $response["message"] = "Either of the parameters is missing, try again";
        echo json_encode($response);
      }
    break;
  }
  case 13:
  {
    require_once 'Processor/page13.php';
    require_once 'Processor/page30.php';
    $db=new page13();
    if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['hangplc']) && isset($_POST['splthere']) )
      {
          $userid=$_POST['userid'];
          $username=$_POST['username'];
          $hp=$_POST['hangplc'];
          $splt=$_POST['splthere'];
          global $flag;
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum['page13']=='Yes')
            $flag=1; //the particular page is already existant because this time was re filled
          else
            $flag=0;     //the particular page is being fille dfor the first time

          if ($db->isUserExisted($userid))
          {
              $user = $db->updateuser($userid,$username,$hp,$splt);
              if($user)
              {
                if($flag==0) //the particular page is being filled for the first time
                  {
                    $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                    $prog=new page30();
                    $val=4; //the value point for completion of the page
                    $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                    $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                  }
                  else if($flag==1) //the particular page is already existant because this time was re filled
                  {
                    $prog=new page30();
                    $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                    $response["progress"] = $dump["progress"]; //binding progress value with json
                  }
                $response["error"] = FALSE;
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          else {
             $user= $db->storeuser($userid,$username,$hp,$splt);
             if($user)
             {
               if($flag==0) //the particular page is being filled for the first time
                 {
                   $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                   $prog=new page30();
                   $val=4; //the value point for completion of the page
                   $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                   $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                 }
                 else if($flag==1) //the particular page is already existant because this time was re filled
                 {
                   $prog=new page30();
                   $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                   $response["progress"] = $dump["progress"]; //binding progress value with json
                 }
               $response["error"] = FALSE;
               $response["message"] = "first time Record submitted, so new entry created";
             }
             else {
               $response["error"] = TRUE;
               $response["message"] = "Record was tried to insert, not inserted";
             }

             echo json_encode($response);

          }
      }
      else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
      {
        $userid=$_POST['userid'];
        $username=$_POST['username'];
        $need=$_POST['need'];
        if($need=='get')
        {
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum)
            $response['value']=$dum['page13'];
          else
           $response['value']="No";

          $response["error"] = FALSE;
          $response["message"] = "Value of requested param is returned";
          echo json_encode($response);
        }
      }
      else
      {
        $response["error"] = TRUE;
        $response["message"] = "Either of the parameters is missing, try again";
        echo json_encode($response);
      }
    break;
  }
  case 14:
  {
    require_once 'Processor/page14.php';
    require_once 'Processor/page30.php';
    $db=new page14();
    if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['holiday']) && isset($_POST['reason']) )
      {
          $userid=$_POST['userid'];
          $username=$_POST['username'];
          $hol=$_POST['holiday'];
          $reason=$_POST['reason'];
          global $flag;
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum['page14']=='Yes')
            $flag=1; //the particular page is already existant because this time was re filled
          else
            $flag=0;     //the particular page is being fille dfor the first time


          if ($db->isUserExisted($userid))
          {
              $user = $db->updateuser($userid,$username,$hol,$reason);
              if($user)
              {
                if($flag==0) //the particular page is being filled for the first time
                  {
                    $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                    $prog=new page30();
                    $val=4; //the value point for completion of the page
                    $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                    $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                  }
                  else if($flag==1) //the particular page is already existant because this time was re filled
                  {
                    $prog=new page30();
                    $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                    $response["progress"] = $dump["progress"]; //binding progress value with json
                  }
                $response["error"] = FALSE;
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          else {
             $user= $db->storeuser($userid,$username,$hol,$reason);
             if($user)
             {
               if($flag==0) //the particular page is being filled for the first time
                 {
                   $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                   $prog=new page30();
                   $val=4; //the value point for completion of the page
                   $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                   $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                 }
                 else if($flag==1) //the particular page is already existant because this time was re filled
                 {
                   $prog=new page30();
                   $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                   $response["progress"] = $dump["progress"]; //binding progress value with json
                 }
               $response["error"] = FALSE;
               $response["message"] = "first time Record submitted, so new entry created";
             }
             else {
               $response["error"] = TRUE;
               $response["message"] = "Record was tried to insert, not inserted";
             }

             echo json_encode($response);

          }
      }
      else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
      {
        $userid=$_POST['userid'];
        $username=$_POST['username'];
        $need=$_POST['need'];
        if($need=='get')
        {
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum)
            $response['value']=$dum['page14'];
          else
           $response['value']="No";

          $response["error"] = FALSE;
          $response["message"] = "Value of requested param is returned";
          echo json_encode($response);
        }
      }
      else
      {
        $response["error"] = TRUE;
        $response["message"] = "Either of the parameters is missing, try again";
        echo json_encode($response);
      }
    break;
  }
  case 15:
  {
    require_once 'Processor/page15.php';
    require_once 'Processor/page30.php';
    $db=new page15();
    if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['hobbies']) )
      {
          $userid=$_POST['userid'];
          $username=$_POST['username'];
          $hob=$_POST['hobbies'];
          global $flag;
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum['page15']=='Yes')
            $flag=1; //the particular page is already existant because this time was re filled
          else
            $flag=0;     //the particular page is being fille dfor the first time



          if ($db->isUserExisted($userid))
          {
              $user = $db->updateuser($userid,$username,$hob);
              if($user)
              {
                if($flag==0) //the particular page is being filled for the first time
                  {
                    $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                    $prog=new page30();
                    $val=4; //the value point for completion of the page
                    $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                    $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                  }
                  else if($flag==1) //the particular page is already existant because this time was re filled
                  {
                    $prog=new page30();
                    $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                    $response["progress"] = $dump["progress"]; //binding progress value with json
                  }
                $response["error"] = FALSE;
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          else {
             $user= $db->storeuser($userid,$username,$hob);
             if($user)
             {
               if($flag==0) //the particular page is being filled for the first time
                 {
                   $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                   $prog=new page30();
                   $val=4; //the value point for completion of the page
                   $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                   $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                 }
                 else if($flag==1) //the particular page is already existant because this time was re filled
                 {
                   $prog=new page30();
                   $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                   $response["progress"] = $dump["progress"]; //binding progress value with json
                 }
               $response["error"] = FALSE;
               $response["message"] = "first time Record submitted, so new entry created";
             }
             else {
               $response["error"] = TRUE;
               $response["message"] = "Record was tried to insert, not inserted";
             }

             echo json_encode($response);

          }
      }
      else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
      {
        $userid=$_POST['userid'];
        $username=$_POST['username'];
        $need=$_POST['need'];
        if($need=='get')
        {
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum)
            $response['value']=$dum['page15'];
          else
           $response['value']="No";

          $response["error"] = FALSE;
          $response["message"] = "Value of requested param is returned";
          echo json_encode($response);
        }
      }
      else
      {
        $response["error"] = TRUE;
        $response["message"] = "Either of the parameters is missing, try again";
        echo json_encode($response);
      }
    break;
  }
  case 16:
  {
    require_once 'Processor/page16.php';
    require_once 'Processor/page30.php';
    $db=new page16();
    if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['memories']) )
      {
          $userid=$_POST['userid'];
          $username=$_POST['username'];
          $mem=$_POST['memories'];
          global $flag;
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum['page16']=='Yes')
            $flag=1; //the particular page is already existant because this time was re filled
          else
            $flag=0;     //the particular page is being fille dfor the first time



          if ($db->isUserExisted($userid))
          {
              $user = $db->updateuser($userid,$username,$mem);
              if($user)
              {
                if($flag==0) //the particular page is being filled for the first time
                  {
                    $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                    $prog=new page30();
                    $val=4; //the value point for completion of the page
                    $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                    $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                  }
                  else if($flag==1) //the particular page is already existant because this time was re filled
                  {
                    $prog=new page30();
                    $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                    $response["progress"] = $dump["progress"]; //binding progress value with json
                  }
                $response["error"] = FALSE;
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          else {
             $user= $db->storeuser($userid,$username,$mem);
             if($user)
             {
               if($flag==0) //the particular page is being filled for the first time
                 {
                   $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                   $prog=new page30();
                   $val=4; //the value point for completion of the page
                   $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                   $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                 }
                 else if($flag==1) //the particular page is already existant because this time was re filled
                 {
                   $prog=new page30();
                   $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                   $response["progress"] = $dump["progress"]; //binding progress value with json
                 }
               $response["error"] = FALSE;
               $response["message"] = "first time Record submitted, so new entry created";
             }
             else {
               $response["error"] = TRUE;
               $response["message"] = "Record was tried to insert, not inserted";
             }

             echo json_encode($response);

          }
      }
      else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
      {
        $userid=$_POST['userid'];
        $username=$_POST['username'];
        $need=$_POST['need'];
        if($need=='get')
        {
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum)
            $response['value']=$dum['page16'];
          else
           $response['value']="No";

          $response["error"] = FALSE;
          $response["message"] = "Value of requested param is returned";
          echo json_encode($response);
        }
      }
      else
      {
        $response["error"] = TRUE;
        $response["message"] = "Either of the parameters is missing, try again";
        echo json_encode($response);
      }
    break;
  }
  case 17:
  {
    require_once 'Processor/page17.php';
    require_once 'Processor/page30.php';
    $db=new page17();
    if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['advice']) )
      {
          $userid=$_POST['userid'];
          $username=$_POST['username'];
          $adv=$_POST['advice'];
          global $flag;
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum['page17']=='Yes')
            $flag=1; //the particular page is already existant because this time was re filled
          else
            $flag=0;     //the particular page is being fille dfor the first time



          if ($db->isUserExisted($userid))
          {
              $user = $db->updateuser($userid,$username,$adv);
              if($user)
              {
                if($flag==0) //the particular page is being filled for the first time
                  {
                    $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                    $prog=new page30();
                    $val=3; //the value point for completion of the page
                    $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                    $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                  }
                  else if($flag==1) //the particular page is already existant because this time was re filled
                  {
                    $prog=new page30();
                    $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                    $response["progress"] = $dump["progress"]; //binding progress value with json
                  }
                $response["error"] = FALSE;
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          else {
             $user= $db->storeuser($userid,$username,$adv);
             if($user)
             {
               if($flag==0) //the particular page is being filled for the first time
                 {
                   $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                   $prog=new page30();
                   $val=3; //the value point for completion of the page
                   $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                   $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                 }
                 else if($flag==1) //the particular page is already existant because this time was re filled
                 {
                   $prog=new page30();
                   $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                   $response["progress"] = $dump["progress"]; //binding progress value with json
                 }
               $response["error"] = FALSE;
               $response["message"] = "first time Record submitted, so new entry created";
             }
             else {
               $response["error"] = TRUE;
               $response["message"] = "Record was tried to insert, not inserted";
             }

             echo json_encode($response);

          }
      }
      else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
      {
        $userid=$_POST['userid'];
        $username=$_POST['username'];
        $need=$_POST['need'];
        if($need=='get')
        {
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum)
            $response['value']=$dum['page17'];
          else
           $response['value']="No";

          $response["error"] = FALSE;
          $response["message"] = "Value of requested param is returned";
          echo json_encode($response);
        }
      }
      else
      {
        $response["error"] = TRUE;
        $response["message"] = "Either of the parameters is missing, try again";
        echo json_encode($response);
      }
    break;
  }
  case 18:
  {
    require_once 'Processor/page18.php';
    require_once 'Processor/page30.php';
    $db=new page18();
    if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['regrets']) && isset($_POST['fear']) )
      {
          $userid=$_POST['userid'];
          $username=$_POST['username'];
          $reg=$_POST['regrets'];
          $fear=$_POST['fear'];
          global $flag;
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum['page18']=='Yes')
            $flag=1; //the particular page is already existant because this time was re filled
          else
            $flag=0;     //the particular page is being fille dfor the first time


          if ($db->isUserExisted($userid))
          {
              $user = $db->updateuser($userid,$username,$reg,$fear);
              if($user)
              {
                if($flag==0) //the particular page is being filled for the first time
                  {
                    $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                    $prog=new page30();
                    $val=4; //the value point for completion of the page
                    $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                    $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                  }
                  else if($flag==1) //the particular page is already existant because this time was re filled
                  {
                    $prog=new page30();
                    $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                    $response["progress"] = $dump["progress"]; //binding progress value with json
                  }
                $response["error"] = FALSE;
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          else {
             $user= $db->storeuser($userid,$username,$reg,$fear);
             if($user)
             {
               if($flag==0) //the particular page is being filled for the first time
                 {
                   $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                   $prog=new page30();
                   $val=4; //the value point for completion of the page
                   $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                   $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                 }
                 else if($flag==1) //the particular page is already existant because this time was re filled
                 {
                   $prog=new page30();
                   $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                   $response["progress"] = $dump["progress"]; //binding progress value with json
                 }
              $response["error"] = FALSE;
               $response["message"] = "first time Record submitted, so new entry created";
             }
             else {
               $response["error"] = TRUE;
               $response["message"] = "Record was tried to insert, not inserted";
             }

             echo json_encode($response);

          }
      }
      else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
      {
        $userid=$_POST['userid'];
        $username=$_POST['username'];
        $need=$_POST['need'];
        if($need=='get')
        {
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum)
            $response['value']=$dum['page18'];
          else
           $response['value']="No";

          $response["error"] = FALSE;
          $response["message"] = "Value of requested param is returned";
          echo json_encode($response);
        }
      }
      else
      {
        $response["error"] = TRUE;
        $response["message"] = "Either of the parameters is missing, try again";
        echo json_encode($response);
      }
    break;
  }
  case 19:
  {
    require_once 'Processor/page19.php';
    require_once 'Processor/page30.php';
    $db=new page19();
    if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['first']) && isset($_POST['did']) && isset($_POST['curr']) )
      {
          $userid=$_POST['userid'];
          $username=$_POST['username'];
          $first=$_POST['first'];
          $did=$_POST['did'];
          $curr=$_POST['curr'];
          global $flag;
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum['page19']=='Yes')
            $flag=1; //the particular page is already existant because this time was re filled
          else
            $flag=0;     //the particular page is being fille dfor the first time


          if ($db->isUserExisted($userid))
          {
              $user = $db->updateuser($userid,$username,$first,$did,$curr);
              if($user)
              {
                if($flag==0) //the particular page is being filled for the first time
                  {
                    $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                    $prog=new page30();
                    $val=4; //the value point for completion of the page
                    $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                    $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                  }
                  else if($flag==1) //the particular page is already existant because this time was re filled
                  {
                    $prog=new page30();
                    $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                    $response["progress"] = $dump["progress"]; //binding progress value with json
                  }
                $response["error"] = FALSE;
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          else {
             $user= $db->storeuser($userid,$username,$first,$did,$curr);
             if($user)
             {
               if($flag==0) //the particular page is being filled for the first time
                 {
                   $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                   $prog=new page30();
                   $val=4; //the value point for completion of the page
                   $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                   $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                 }
                 else if($flag==1) //the particular page is already existant because this time was re filled
                 {
                   $prog=new page30();
                   $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                   $response["progress"] = $dump["progress"]; //binding progress value with json
                 }
               $response["error"] = FALSE;
               $response["message"] = "first time Record submitted, so new entry created";
             }
             else {
               $response["error"] = TRUE;
               $response["message"] = "Record was tried to insert, not inserted";
             }

             echo json_encode($response);

          }
      }
      else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
      {
        $userid=$_POST['userid'];
        $username=$_POST['username'];
        $need=$_POST['need'];
        if($need=='get')
        {
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum)
            $response['value']=$dum['page19'];
          else
           $response['value']="No";

          $response["error"] = FALSE;
          $response["message"] = "Value of requested param is returned";
          echo json_encode($response);
        }
      }
      else
      {
        $response["error"] = TRUE;
        $response["message"] = "Either of the parameters is missing, try again";
        echo json_encode($response);
      }
    break;
  }
  case 20:
  {
    require_once 'Processor/page20.php';
    require_once 'Processor/page30.php';
    $db=new page20();
    if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['bucket']) )
      {
          $userid=$_POST['userid'];
          $username=$_POST['username'];
          $buck=$_POST['bucket'];
          global $flag;
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum['page20']=='Yes')
            $flag=1; //the particular page is already existant because this time was re filled
          else
            $flag=0;     //the particular page is being fille dfor the first time



          if ($db->isUserExisted($userid))
          {
              $user = $db->updateuser($userid,$username,$buck);
              if($user)
              {
                if($flag==0) //the particular page is being filled for the first time
                  {
                    $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                    $prog=new page30();
                    $val=4; //the value point for completion of the page
                    $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                    $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                  }
                  else if($flag==1) //the particular page is already existant because this time was re filled
                  {
                    $prog=new page30();
                    $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                    $response["progress"] = $dump["progress"]; //binding progress value with json
                  }
                $response["error"] = FALSE;
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          else {
             $user= $db->storeuser($userid,$username,$buck);
             if($user)
             {
               if($flag==0) //the particular page is being filled for the first time
                 {
                   $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                   $prog=new page30();
                   $val=4; //the value point for completion of the page
                   $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                   $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                 }
                 else if($flag==1) //the particular page is already existant because this time was re filled
                 {
                   $prog=new page30();
                   $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                   $response["progress"] = $dump["progress"]; //binding progress value with json
                 }
              $response["error"] = FALSE;
               $response["message"] = "first time Record submitted, so new entry created";
             }
             else {
               $response["error"] = TRUE;
               $response["message"] = "Record was tried to insert, not inserted";
             }

             echo json_encode($response);

          }
      }
      else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
      {
        $userid=$_POST['userid'];
        $username=$_POST['username'];
        $need=$_POST['need'];
        if($need=='get')
        {
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum)
            $response['value']=$dum['page20'];
          else
           $response['value']="No";

          $response["error"] = FALSE;
          $response["message"] = "Value of requested param is returned";
          echo json_encode($response);
        }
      }
      else
      {
        $response["error"] = TRUE;
        $response["message"] = "Either of the parameters is missing, try again";
        echo json_encode($response);
      }
    break;
  }
  case 21:
  {
    require_once 'Processor/page21.php';
    require_once 'Processor/page30.php';
    $db=new page21();
    if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['hurt']) )
      {
          $userid=$_POST['userid'];
          $username=$_POST['username'];
          $hurt=$_POST['hurt'];
          global $flag;
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum['page21']=='Yes')
            $flag=1; //the particular page is already existant because this time was re filled
          else
            $flag=0;     //the particular page is being fille dfor the first time



          if ($db->isUserExisted($userid))
          {
              $user = $db->updateuser($userid,$username,$hurt);
              if($user)
              {
                if($flag==0) //the particular page is being filled for the first time
                  {
                    $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                    $prog=new page30();
                    $val=4; //the value point for completion of the page
                    $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                    $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                  }
                  else if($flag==1) //the particular page is already existant because this time was re filled
                  {
                    $prog=new page30();
                    $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                    $response["progress"] = $dump["progress"]; //binding progress value with json
                  }
                $response["error"] = FALSE;
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          else {
             $user= $db->storeuser($userid,$username,$hurt);
             if($user)
             {
               if($flag==0) //the particular page is being filled for the first time
                 {
                   $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                   $prog=new page30();
                   $val=4; //the value point for completion of the page
                   $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                   $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                 }
                 else if($flag==1) //the particular page is already existant because this time was re filled
                 {
                   $prog=new page30();
                   $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                   $response["progress"] = $dump["progress"]; //binding progress value with json
                 }
               $response["error"] = FALSE;
               $response["message"] = "first time Record submitted, so new entry created";
             }
             else {
               $response["error"] = TRUE;
               $response["message"] = "Record was tried to insert, not inserted";
             }

             echo json_encode($response);

          }
      }
      else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
      {
        $userid=$_POST['userid'];
        $username=$_POST['username'];
        $need=$_POST['need'];
        if($need=='get')
        {
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum)
            $response['value']=$dum['page21'];
          else
           $response['value']="No";

          $response["error"] = FALSE;
          $response["message"] = "Value of requested param is returned";
          echo json_encode($response);
        }
      }
      else
      {
        $response["error"] = TRUE;
        $response["message"] = "Either of the parameters is missing, try again";
        echo json_encode($response);
      }
    break;
  }
  case 22:
  {
    require_once 'Processor/page22.php';
    require_once 'Processor/page30.php';
    $db=new page22();
    if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['q1']) && isset($_POST['q2']) && isset($_POST['q3']) && isset($_POST['q4']) && isset($_POST['q5']) && isset($_POST['q6']) && isset($_POST['q7']) && isset($_POST['q8']) && isset($_POST['q9']) && isset($_POST['q10']) && isset($_POST['q11']) && isset($_POST['q12']) && isset($_POST['q13']) )
      {
          $userid=$_POST['userid'];
          $username=$_POST['username'];
          $q1=$_POST['q1'];
          $q2=$_POST['q2'];
          $q3=$_POST['q3'];
          $q4=$_POST['q4'];
          $q5=$_POST['q5'];
          $q6=$_POST['q6'];
          $q7=$_POST['q7'];
          $q8=$_POST['q8'];
          $q9=$_POST['q9'];
          $q10=$_POST['q10'];
          $q11=$_POST['q11'];
          $q12=$_POST['q12'];
          $q13=$_POST['q13'];
          global $flag;
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum['page22']=='Yes')
            $flag=1; //the particular page is already existant because this time was re filled
          else
            $flag=0;     //the particular page is being fille dfor the first time


          if ($db->isUserExisted($userid))
          {
              $user = $db->updateuser($userid,$username,$q1,$q2,$q3,$q4,$q5,$q6,$q7,$q8,$q9,$q10,$q11,$q12,$q13);
              if($user)
              {
                if($flag==0) //the particular page is being filled for the first time
                  {
                    $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                    $prog=new page30();
                    $val=6; //the value point for completion of the page
                    $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                    $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                  }
                  else if($flag==1) //the particular page is already existant because this time was re filled
                  {
                    $prog=new page30();
                    $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                    $response["progress"] = $dump["progress"]; //binding progress value with json
                  }
                $response["error"] = FALSE;
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          else {
             $user= $db->storeuser($userid,$username,$q1,$q2,$q3,$q4,$q5,$q6,$q7,$q8,$q9,$q10,$q11,$q12,$q13);
             if($user)
             {
               if($flag==0) //the particular page is being filled for the first time
                 {
                   $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                   $prog=new page30();
                   $val=6; //the value point for completion of the page
                   $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
                   $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
                 }
                 else if($flag==1) //the particular page is already existant because this time was re filled
                 {
                   $prog=new page30();
                   $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                   $response["progress"] = $dump["progress"]; //binding progress value with json
                 }
               $response["error"] = FALSE;
               $response["message"] = "first time Record submitted, so new entry created";
             }
             else {
               $response["error"] = TRUE;
               $response["message"] = "Record was tried to insert, not inserted";
             }

             echo json_encode($response);

          }
      }
      else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
      {
        $userid=$_POST['userid'];
        $username=$_POST['username'];
        $need=$_POST['need'];
        if($need=='get')
        {
          $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
          if($dum)
            $response['value']=$dum['page22'];
          else
           $response['value']="No";

          $response["error"] = FALSE;
          $response["message"] = "Value of requested param is returned";
          echo json_encode($response);
        }
      }
      else
      {
        $response["error"] = TRUE;
        $response["message"] = "Either of the parameters is missing, try again";
        echo json_encode($response);
      }
    break;
  }
  case 23:
  {
    require_once 'Processor/page23.php';
    require_once 'Processor/page30.php';
    $db=new page23();
    if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['bfa']) && isset($_POST['reply']) && isset($_POST['pdf']) && isset($_POST['doc']))
    {
      $userid=$_POST['userid'];
      $username=$_POST['username'];
      $bfa=$_POST['bfa'];
      $rep=$_POST['reply'];
      $pdf=$_POST['pdf'];
      $doc=$_POST['doc'];
      global $flag;
      $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
      if($dum['page23']=='Yes')
        $flag=1; //the particular page is already existant because this time was re filled
      else
        $flag=0;     //the particular page is being fille dfor the first time


      if ($db->isUserExisted($userid))
      {
          $user = $db->updateuser($userid,$username,$bfa,$rep,$pdf,$doc);
          if($user)
          {
            if($flag==0) //the particular page is being filled for the first time
              {
                $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
                $prog=new page30();
                $val=5; //the value point for completion of the page
                $dump=$prog->updateprogress($userid,$username,$val); //since the page is not being filled for the forst time, the progress is being updated
                $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
              }
              else if($flag==1) //the particular page is already existant because this time was re filled
              {
                $prog=new page30();
                $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
                $response["progress"] = $dump["progress"]; //binding progress value with json
              }
            $response["error"] = FALSE;
            $response["message"] = "Record  already existed. so entry updated";

          }
          else {
            $response["error"] = TRUE;
            $response["message"] = "Record  was tried to update, not updated";
          }
          echo json_encode($response);
      }
      else {
         $user= $db->storeuser($userid,$username,$bfa,$rep,$pdf,$doc);
         if($user)
         {
           if($flag==0) //the particular page is being filled for the first time
             {
               $db->setPageStat($userid,$username);  //the page's completion status will be set to yes
               $prog=new page30();
               $val=5; //the value point for completion of the page
               $dump=$prog->updateprogress($userid,$username,$val); //since the page is  being filled for the forst time, the progress is being stored
               $response["progress"] = $dump["progress"]; // the current progress will  be sent with the json data, so binding it
             }
             else if($flag==1) //the particular page is already existant because this time was re filled
             {
               $prog=new page30();
               $dump = $prog->returninfo($userid,$username,"blahblah"); //here, just the current progresswill be returned wih thr json data, no modif is being done
               $response["progress"] = $dump["progress"]; //binding progress value with json
             }
           $response["error"] = FALSE;
           $response["message"] = "first time Record submitted, so new entry created";
         }
         else {
           $response["error"] = TRUE;
           $response["message"] = "Record was tried to insert, not inserted";
         }

         echo json_encode($response);
    }}
    else if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']))
    {
      $userid=$_POST['userid'];
      $username=$_POST['username'];
      $need=$_POST['need'];
      if($need=='get')
      {
        $dum=$db->retPageStat($userid);  //the current status of page in the pagination table is determined
        if($dum)
          $response['value']=$dum['page23'];
        else
         $response['value']="No";

        $response["error"] = FALSE;
        $response["message"] = "Value of requested param is returned";
        echo json_encode($response);
      }
    }

    else
    {
      $response["error"] = TRUE;
      $response["message"] = "Either of the parameters is missing, try again";
      echo json_encode($response);
    }
    break;
  }
  case 30:
  {
    require_once 'Processor/page30.php';
    $db=new page30();
    if(isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['need']) && isset($_POST['requirement']) && isset($_POST['value']) )
    {
      $userid=$_POST['userid'];
      $username=$_POST['username'];
      $need=$_POST['need'];
      $req=$_POST['requirement'];
      $val=$_POST['value'];

      if ($db->isUserExisted($userid))
      {
        if($need=='put')
        {
            if($req=='progress')
            {
              $user = $db->updateprogress($userid,$username,$val);
              if($user)
              {
                $response["error"] = FALSE;
                $response["message"] = "Record  already existed. so entry updated";
              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";            }
              echo json_encode($response);
            }
            if($req=='lastLogin')
            {

                $user = $db->updatelogin($userid,$username,$val);
                if($user)
                {
                  $response["error"] = FALSE;
                  $response["message"] = "Record  already existed. so entry updated";

                }
                else {
                  $response["error"] = TRUE;
                  $response["message"] = "Record  was tried to update, not updated";
                }
                echo json_encode($response);
            }
            if($req=='reminderTime')
            {

                $user = $db->updatereminder($userid,$username,$val);
                if($user)
                {
                  $response["error"] = FALSE;
                  $response["message"] = "Record  already existed. so entry updated";

                }
                else {
                  $response["error"] = TRUE;
                  $response["message"] = "Record  was tried to update, not updated";
                }
                echo json_encode($response);
            }
            if($req=='reqAttn')
            {

                $user = $db->updateAttn($userid,$username,$val);
                if($user)
                {
                  $response["error"] = FALSE;
                  $response["message"] = "Record  already existed. so entry updated";

                }
                else {
                  $response["error"] = TRUE;
                  $response["message"] = "Record  was tried to update, not updated";
                }
                echo json_encode($response);
            }
        }
        else if($need=='get')
        {
          if($req=='progress')
          {
            $user = $db->returninfo($userid,$username,$val);
            if($user)
            {
              $response["error"] = FALSE;
              $response["value"] = $user["progress"];
              $response["message"] = "progress returned";
            }
            else {
              $response["error"] = TRUE;
              $response["message"] = "Prgress is not being returned due to an error";            }
            echo json_encode($response);
          }
          if($req=='lastLogin')
          {

              $user = $db->returninfo($userid,$username,$val);
              if($user)
              {
                $response["error"] = FALSE;
                $response["value"] = $user["lastLogin"];
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          if($req=='reminderTime')
          {

              $user = $db->returninfo($userid,$username,$val);
              if($user)
              {
                $response["error"] = FALSE;
                $response["value"] = $user["reminderIfSet_time"];
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
          if($req=='reqAttn')
          {

              $user = $db->returninfo($userid,$username,$val);
              if($user)
              {
                $response["error"] = FALSE;
                $response["value"] = $user["requireATTENTION"];
                $response["message"] = "Record  already existed. so entry updated";

              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record  was tried to update, not updated";
              }
              echo json_encode($response);
          }
        }

      }
      else {
          if($need=='put')
          {
            if($req=='progress')
              {
                $user =$db->updateprogress($userid,$username,$val);
                if($user)
                  {
                      $response["error"] = FALSE;
                      $response["message"] = "first time Record submitted, so new entry created";
                    }
                  else {
                      $response["error"] = TRUE;
                      $response["message"] = "Record was tried to insert, not inserted";
                    }

                    echo json_encode($response);
                  }
            if($req=='lastLogin')
              {
                $user = $db->storelogin($userid,$username,$val);
                if($user)
                  {
                    $response["error"] = FALSE;
                    $response["message"] = "first time Record submitted, so new entry created";
                  }
                  else {
                    $response["error"] = TRUE;
                    $response["message"] = "Record was tried to insert, not inserted";
                    }
              echo json_encode($response);
              }
              if($req=='reminderTime')
                {
                  $user = $db->storereminder($userid,$username,$val);
                  if($user)
                  {
                    $response["error"] = FALSE;
                    $response["message"] = "first time Record submitted, so new entry created";
                  }
                  else {
                    $response["error"] = TRUE;
                    $response["message"] = "Record was tried to insert, not inserted";
                      }
              echo json_encode($response);
              }
              if($req=='reqAttn')
              {
              $user = $db->storeAttn($userid,$username,$val);
              if($user)
              {
                $response["error"] = FALSE;
                $response["message"] = "first time Record submitted, so new entry created";
              }
              else {
                $response["error"] = TRUE;
                $response["message"] = "Record was tried to insert, not inserted";
              }

              echo json_encode($response);
            }
        }
        else if($need=='get')
        {
          $response["error"] = FALSE;
          $response["value"] = 0;
          $response["message"] = "User details not yet entered, so get only after putting once";
               echo json_encode($response);
        }
            }
    }

    else
    {
      $response["error"] = TRUE;
      $response["message"] = "Either of the parameters is missing, try again";
      echo json_encode($response);
    }
    break;
  }

  default:
   {
     $response["error"] = TRUE;
     $response["message"] = "Wrong Route Mate!";
     echo json_encode($response);
   }

}

 ?>
