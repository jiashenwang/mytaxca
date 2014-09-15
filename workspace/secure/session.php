<?php

  // Includes objects.php
  require ( 'connector.php' );

  // Starts session
  session_start();

  // Set session cookie to httponly, prevents javascript access to cookies
  $current = session_get_cookie_params();
  session_set_cookie_params(
    $current['lifetime'],
    $current['path'],
    $current['domain'],
    $current['secure'],
    true
  );

  // Basic authentication. TODO: probably should add more
  if( !isset($_SESSION['info']) ){
    logout();
  }else{
    
    // Sanitizes email & name before any form of printing 
    $email = filter_var( $_SESSION['info']->getEmail(), FILTER_SANITIZE_EMAIL );
    $name = filter_var( $_SESSION['info']->getName(), FILTER_SANITIZE_FULL_SPECIAL_CHARS );
    
    // level not sanitized as it's set by the system. TODO: sanitize if there's any change
    $level = $_SESSION['info']->getLevel();
    
    // No sanitation, id is made server side
    $id = $_SESSION['info']->getId();
  }

  function logout(){
    header( "Location: action/logout.php" );
  }

?>