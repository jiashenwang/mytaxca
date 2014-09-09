<?php

  // Unsets everything in $_SESSION array
  session_unset();

  // Destroys session data from server disk
  session_destroy();

  header( 'Location: ../index.php' );

?>