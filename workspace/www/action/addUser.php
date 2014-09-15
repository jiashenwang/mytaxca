<?php
  session_start();
  include '../../secure/connector.php';
  
  $email = $_POST['new_email'];
  $name = $_POST['new_name'];
  $pass = $_POST['initial_pass'];
  $level = $_POST['new_level'];
    
  global $user;
  if($connection = new Connector()){
     if($user = $connection->make($email,$name,$pass,$level)){
          echo json_encode($user);
          exit;
     }
   }
      //  $result = mysqli_query($con,$sql) or die('Error creating user');
    
?>
