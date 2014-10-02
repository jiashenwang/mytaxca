<?php
  // Include validators
  require ( '../../secure/session.php' );
  
  $data = array();
  $email = filter_var( $_SESSION['info']->getEmail(), FILTER_SANITIZE_EMAIL );
  $name = filter_var( $_SESSION['info']->getName(), FILTER_SANITIZE_FULL_SPECIAL_CHARS );
  
  $data['email'] = $email;
  $data['name'] = $name;
  echo json_encode($data);
  
?>