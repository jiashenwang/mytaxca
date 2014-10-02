<?php
  session_start();

  // Include validators
  require ( '../../secure/connector.php' );

  // Alert message
  $message = "<strong>Failure!</strong> Could not make Task!";

  if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if( $connection = new Connector()){
      $array = array();
      if( $users = $connection->user_getAll()){
        foreach($users as $user) {
          $array[] = array('user_id'=>$user->getId(),
                            'user_email'=>$user->getEmail(),
                            'user_name'=>$user->getName()
                          );            
        }
         if(isset($array)){
            echo json_encode($array);
         }else{
           echo('Nothing to display.');
         }   
        //header('HTTP/1.1 200 OK');
        exit;
      }else{
          header('HTTP/1.1 403 Forbidden');
          exit;
        }
    }else{
      header('HTTP/1.1 403 Forbidden!!!');
      exit;
    }
  }

?>