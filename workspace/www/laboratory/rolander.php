<?php

  $message = "NOTHING";

  if( isset($_POST['string']) ){
    $string = $_POST['string'];
    
    $array = array();
    
    $array['PURE'] = $string;
    $array['FILTER ONLY'] = filter_var( $string, FILTER_SANITIZE_STRING );
    $array['ENCODE LOW'] = filter_var( $string, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW );
    $array['ENCODE HIGH'] = filter_var( $string, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH );
    $array['ENCODE AMP'] = filter_var( $string, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_AMP );
    $array['SPECIAL CHARS'] = filter_var( $string, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
    
    $message = NULL;
    foreach( $array as $key => $value)
      $message .= <<< HTML
        $key => $value<br>
HTML;
  }

  function test($string){
    $array = array();
    
    $array['FILTER ONLY'] = filter_var( $string, FILTER_SANITIZE_STRING );
    $array['ENCODE LOW'] = filter_var( $string, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW );
    $array['ENCODE HIGH'] = filter_var( $string, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH );
    $array['ENCODE AMP'] = filter_var( $string, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_AMP );
    $array['SPECIAL CHARS'] = filter_var( $string, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
    $array['PURE'] = $string;
    
    $body = "<hr>";
    foreach( $array as $key => $value){
      $body .= <<< HTML
        $key => $value<br>
HTML;
    }
    return $body;
  }

  $message  = test("<script>alert('1')</script>");
  $message .= test("&ltscript&gtalert('2')&lt/script&gt");
  $message .= test("&lt;script&gt;alert('3')&lt;/script&gt;");
  $message .= test("<!--");

?>

<!DOCTYPE html>
<html>
  <head>
    <title>R</title>
  </head>
  
  <body>
    <h1>Laboratory</h1>
    <p>There should be a form at the bottom</p>
    
    <?= $message ?>
    
    <form method="POST" action="/rolander.php">
      <input type="text" name="string">
      <input type="submit" value="send">
    </form>
    
  </body>
  
</html>