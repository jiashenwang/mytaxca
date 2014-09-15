<?php

  session_start();

  // Include validators
  require ( '../../secure/connector.php' );

  // Make sure this is invoked by a POST only
  if( isset($_POST) && empty($_GET) ){
    
    // Validates POST array
    if( $result = method_validate( $_POST, ['NTclientid', 'NTclientname', 'NTname', 'NTdescription', 'NTuserid', 'NTusername', 'NTdeadline', 'NTcomment']) ){
      action( $_POST );
    }
    header('HTTP/1.1 400 Bad Request');
    exit;
  }

  // Restricted access failure
  header('HTTP/1.1 404 Not Found');
  exit;

  // Action, queries credentials
  function action( $Data ){
    
    if( $connection = new Connector()){
        if( $connection->task_create( 
          $Data['NTclientid'], $Data['NTclientname'], $Data['NTname'], $Data['NTdescription'], $Data['NTuserid'], $Data['NTusername'], $Data['NTdeadline'], $Data['NTcomment'] ) ){
          success();
        }
      
      failure();
    }
    failure();
  }

  function failure(){
    echo <<< HTML
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>Failure!</strong> Task could not be made!
      </div> 
HTML;
    header('HTTP/1.1 403 Forbidden');
    exit;
  }
       
  function success(){
    echo <<< HTML
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>Success!</strong> Task made!
      </div> 
HTML;
    header('HTTP/1.1 200 OK');
    exit;
  }
?> 