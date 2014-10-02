<?php
  session_start();
  session_unset();
  session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>mytaxca Index</title>
    
    <script src="/js/jquery-1.11.0.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
      
      function login(event){
                
        var formData = {
          'IDXemail' : $('input[name=email]').val(),
          'IDXpassword' : $('input[name=password]').val()
        };

        // Create our ajax requests
        $.ajax({
          url: "/action/login.php",
          type: "POST", 
          data: formData, 
          dataType: "html"
        })
        
        // Success, redirect
        .done(function() {
          window.location = "dashboard.php";
        })

        // Failed, check status code
        .fail(function( xhr ) {
          switch( xhr.status ){
            case 400:
              $( 'input[name=email]' ).val('');
              $( 'input[name=email]' ).focus();
              $( "#notifications" ).html( xhr.responseText );
              break;
            case 403:
              $( "#notifications" ).html( xhr.responseText );
              $( 'input[name=password]' ).focus();
              break;
            default:
              break;
          }

          $( 'input[name=password]' ).val('');
        });    
        
        event.preventDefault();
      }
    </script>
    
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
          
  </head>

  <body style="background: url(/assets/images/tex_background.jpg) no-repeat center center fixed">
    
    <div>
      
      <div id="notifications" style="margin-top:20px; width:600px; left:0; right:0; margin-left:auto; margin-right:auto"></div>
      
      <div class="well" style="position:fixed; top:120px; width:300px; left:0; right:0; margin-left:auto; margin-right:auto; background-color: white">
        <h2 class="form-signin-heading" style="margin-top:0">Log in</h2>
        <form class="form-signin" role="form" onsubmit="login(event)">
          <input style="margin-bottom:5px" type="email" name="email" class="form-control" placeholder="Email address" required autofocus>
          <input style="margin-bottom:5px" type="password" name="password" class="form-control" placeholder="Password" required>
          <button class="btn btn-primary btn-block" type="submit">Sign in</button>
        </form>
      </div>
      
    </div>
  </body>
</html>