<?php

  // Includes connector.php
  // Includes SESSION validation
  require ( '../../secure/session.php' );

  // Includes table maker
  require ( $_SERVER['DOCUMENT_ROOT'] . '/includes/carpenter.php' );

  // Make sure this is invoked by a POST only
  if( isset($_POST) && empty($_GET) ){
    
    if( method_validate( $_POST, ['Smethod', 'Skeyword'] ) ){
      action( $_POST );
    }
  }

  header('HTTP/1.1 404 Not Found');
  exit;

  function action( $data ){
    
    // Defined by session.php
    global $id;
    global $level;
    
    $method = $data['Smethod'];
    $keyword = $data['Skeyword'];
    
    if( $connection = new Connector() ){
      if( $Tasks = $connection->task_search( $id, $level, $method, $keyword ) ){
        echo table_make( $Tasks, TRUE );
        exit;
      }else{
        
        $string = filter_var( $keyword, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        
        echo <<< HTML
          <span class="caps-style">NO RESULTS FOUND FOR</span> "$string"
HTML;
        exit;
      }
    }
  }
?>