<?php
  session_start();

  // Include validators
  require ( '../../secure/connector.php' );

      $name = $_POST['new_name'];
      $email = $_POST['new_email'];
      $level = $_POST['new_level'];
      $pass = $_POST['initial_pass'];

      $connection = new Connector();
      $result = $connection->make($email,$name,$pass,$level);
      if($result == true){
          echo "Successfully registered";
          exit; 
      }
      else {
        echo "Failed to register";
        exit;
      }
?>
