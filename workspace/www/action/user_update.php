<?php
  // Include validators
  require ( '../../secure/session.php' );

  // Make sure it's a POST and not a GET
  if( isset($_POST) && empty($_GET) ){
    
    // Make sure the POST array hax these exact indexes
    // That's why I used prefixes for array indexes, so we can tell it's coming from editAcc.js
    if( method_validate($_POST, ['EAemail', 'EAname', 'EAold_password', 'EAnew_password']) ){
      action( $_POST );
    }
  }

  // If anything fails, act that action page doesn't exist
  header("HTTP/1.1 404 Not Found");
  exit;

  // Main, gets called when all validation passes
  function action( $data ){
    
    $email = $data['EAemail'];
    $name = $data['EAname'];
    $old_password = $data['EAold_password'];
    $new_password = $data['EAnew_password'];
    
    if( $connection = new Connector() ){
          if( $connection->user_update( $email, $name, $old_password, $new_password ) ){
            // Success
         //   header("HTTP/1.1 200 OK");
            echo "1";  // updated
            exit;
          }
           echo "2";  // check the old password
          exit;
    }
    
    // mysql failure, show bad request
 //   header("HTTP/1.1 400 Bad Request");
          echo "3";
    exit;
  }

  /*
  $input_email = (isset($_POST['new_email']) ? $_POST['new_email'] : null);
  $input_pass = (isset($_POST['old_pass']) ? $_POST['old_pass']: null);
  $input_name = (isset($_POST['new_name']) ? $_POST['new_name']: null);

  echo $input_email . " + " . $input_pass . " + " . $input_name . "!\n ";

  if( $connection = new Connector() ){
    if( $User = $connection->update_user( $input_email, $input_pass, $input_name ) ){
      echo $name;  // Password match
      echo "DONE!";
      // update password
    }else{ echo "update failed, check your old password again"; } // password not match }     
  }else{  echo "Couldn't connect"; } // failed to connect to DB}
  */
?>