<?php

  require ( '../../secure/security.php' );
  
  $method = array( 'one' => '1', 'two' => '1' );
  //$expected = array( 'two' => '1', 'three' => '1', 'four' => '1' );
  $expected = [ 'two', 'three', 'four' ];

  $message = sizeof( array_diff_key($expected, $method) );
  
  $message .= "<br>";

  foreach( $expected as $key => $value ){
    $message .= $key . " => " . $value . "<br>";
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <title>R</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
  </head>
  
  <body>
    <div class="container">
      
      <h1>Laboratory</h1>
      
      <div id="response-container">
        <?= "GOT " . $message ?>
      </div>
     
    </div>
    
  </body>
  
</html>