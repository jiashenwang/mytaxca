<?php

  require( '../../secure/connector.php' );

  if( isset($_POST) && empty($_GET) && (sizeof($_POST) == 4) ){
    
    if( $_POST['secret'] == "OneTrueGodRolando" ){
      $con = new Connector();

      if( $con->make($_POST['email'], $_POST['name'], $_POST['password'], 3) ){
        exit;
      }
      
      header( 'HTTP/1.1 400 Bad Request' );
      exit;
    }
    
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
    
  }

?>

<!DOCTYPE html>
<html>
  
  <head>
    
    <title>Heavens Gate</title>
    
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="/js/jquery-1.11.0.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
      
      function birth(event){
        
        var formData = {
          'email' : $('input[name=email]').val(),
          'name' : $('input[name=name]').val(),
          'password' : $('input[name=password]').val(),
          'secret' : $('input[name=secret]').val()
        }
                
        $.ajax({
          url: "rolanderS.php",
          type: "POST", 
          data: formData, 
          dataType: "html"
        })
        
        .done( function() {
          alert( 'Birth given! Thanks Rolando!' );
          alert( 'Seriously, thanks!' );
          alert( 'Ok, one more. Sorry' );
        })
             
        .fail( function( xhr ) {
          switch( xhr.status ){
            case 400:
              alert( "Birth denied!" );
              $('input[name=email]').val('');
              $('input[name=name]').val('');
              break;
            case 403:
              alert( "Passphrase?" );
              $('input[name=secret]').focus();
              break;
            default:
              alert( "WTF" );
          }
          
          $('input[name=password]').val('');
          $('input[name=secret]').val('');
          
        });
        
        event.preventDefault();
      }
      
    </script>
  </head>
  
  <body>
    
    <div class="container">
      
      <div style="margin:120px auto 0 auto; left:0; right:0">
        <h4>Rolando Birthing Technologies Inc.</h4>
        <form onsubmit="birth(event)" role="form">
          <input type="email" name="email" placeholder="Email" autofocus required>
          <input type="text" name="name" placeholder="Username" required>
          <input pattern=".{6,}" type="password" title="Size 6+"  name="password" placeholder="Password" required>
          <input type="text" name="secret" placeholder="Secret phrase" required>
          <input type="submit" value="Rolando Please!">
        </form>
      </div>
      
      
    </div>
    
    
  </body>
</html>