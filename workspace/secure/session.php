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

  // USE FOR HTML/CSS VALIDATION
  /*
  $email = "debug.mail";
  $name = "debug.mode";
  $id = "U541c004d7cec1"; // Validator's id
  $level = OWNER;
  */

  ///*
  // Basic authentication. TODO: probably should add more
  if( !isset($_SESSION['info']) ){
    logout();
  }else{
    
    // Sanitizes all inputs
    $email = filter_var( $_SESSION['info']->getEmail(), FILTER_SANITIZE_EMAIL );
    $name = filter_var( $_SESSION['info']->getName(), FILTER_SANITIZE_FULL_SPECIAL_CHARS );
    $id = filter_var( $_SESSION['info']->getId(), FILTER_SANITIZE_FULL_SPECIAL_CHARS );
    
    $level = filter_var( $_SESSION['info']->getLevel(), FILTER_SANITIZE_NUMBER_INT );
    
  }
  //*/

  function logout(){
    header( "Location: /action/logout.php" );
  }

?>