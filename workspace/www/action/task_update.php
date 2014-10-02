<?php

  // Includes connector.php
  // Includes SESSION validation
  require ( '../../secure/session.php' );

  // Make sure this is invoked by a POST only
  if( isset($_POST) && empty($_GET) ){

    // Validates POST array
    if( $result = method_validate( $_POST, ['TUFtaskid', 'TUFpinned', 'TUFstatus', 'TUFdescription', 'TUFuser', 'TUFuserid', 'TUFdeadline', 'TUFcomment']) ){
      action( $_POST );
    }
    header('HTTP/1.1 400 Bad Request');
    exit;
  }

  header('HTTP/1.1 404 Not Found');
  exit;

  function success(){
    exit;
  }

  // Main
  function action( $array ){
    
    // OPTIONAL: Add sanitation
    $taskid = $array['TUFtaskid'];
    $pinned = $array['TUFpinned'];
    $status = $array['TUFstatus'];
    $description = $array['TUFdescription'];
    $user = $array['TUFuser'];
    $userid = $array['TUFuserid'];
    $deadline = $array['TUFdeadline'];
    $comment = $array['TUFcomment'];
    
    if( $connection = new Connector() ){
      if( $connection->task_update( $taskid, $pinned, $status, $description, $user, $userid, $deadline, $comment ) ){
        success();
      }
    }
  }
?>