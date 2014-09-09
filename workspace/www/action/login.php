<?php
  session_start();

  // Include validators
  require ( '../../secure/connector.php' );

  // Ensure HTTP METHODS are set and unset respectively
  if( isset($_POST) && empty($_GET) ){
    
    // Validates POST array
    if( $result = method_validate( $_POST, ['IDXemail', 'IDXpassword'] ) ){
      
      $email = $_POST['IDXemail'];
      $password = $_POST['IDXpassword'];
      
      action( $email, $password );
    }
  }

  // Restricted access failure
  header('HTTP/1.1 404 Not Found');

  // Action, queries credentials
  function action($email, $password){
    if( filter_var($email, FILTER_VALIDATE_EMAIL) ){
      if( $connection = new Connector() ){
        if( $User = $connection->login( $email, $password ) ){
          $_SESSION['info'] = $User;
          header('HTTP/1.1 200 OK');
          exit;
        }
      }
      header('HTTP/1.1 403 Forbidden');
    }else{
      header('HTTP/1.1 400 Bad Request');
    }
    failure();
  }

  // Validation failure
  function failure(){
    echo <<< HTML
      <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>Warning!</strong> Invalid email address or password
      </div>
HTML;
    exit;
  }
?>