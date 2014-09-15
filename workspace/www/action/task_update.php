<?php

  session_start();

  // Include validators
  require ( '../../secure/connector.php' );

  // Make sure this is invoked by a POST only
  if( isset($_POST) && empty($_GET) ){
    
    // Validates POST array
    if( $result = method_validate( $_POST, ['TUFtaskid', 'TUFpinned', 'TUFstatus', 'TUFdescription', 'TUFuser', 'TUFuserid', 'TUFdeadline', 'TUFcomment']) ){
      action( $_POST );
    }
    header('HTTP/1.1 400 Bad Request');
    exit;
  }

  function success(){
    echo "SUCCESSFUL UPDATE, REFRESH required. TODO ajax this step up";
    header('HTTP/1.1 200 OK');
    exit;
  }

  // Main
  function action( $array ){
    
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