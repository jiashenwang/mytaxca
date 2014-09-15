<?php
  session_start();
  require ( '../../secure/connector.php' );
  
  $email = $_POST['new_email'];
  if($email==''){echo '';}
  else{
        $con = mysqli_connect(DB_HOST,DB_USER,DB_PW,DB_DB);
        if (!$con) { die('Could not connect: ' . mysqli_error($con)); }

        $sql = "SELECT email from users where email = '".$email."'";
        $result = mysqli_query($con,$sql) or die('Error finding email');
        $data = mysqli_fetch_row($result);
        if($data > 1){
            echo '<div style="color:red">*That email is already used</div>';
        }
        else{
            echo '<div style="color:green">Good to use !!</div>';
        }
  }
?>
