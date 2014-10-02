<?php

  require( '../../secure/connector.php' );

  if( isset($_POST) && empty($_GET) ){
    
    if( isset($_POST['sent']) ){
      $array = array(
        'not_started' => 2,
        'in_progress' => 3,
        'done' => 5,
        'total' => 6,
        'response' => <<< HTML
          <div style="background-color:red">
            AMAZING COLOR WITH AMAZING STUFF
            <hr>
            <span style="color:white">WITH AMAZING SPANS</span>
            <span style="background-color:black; color:red">WITH MORE AWESOME SHIT</span>
          </div>
HTML
      );

      echo json_encode( $array );
      exit;
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    
    <title>R Advanced Systems</title>
    
    <link href="/assets/css/style.css" rel="stylesheet">
    
    <script src="/js/jquery-1.11.0.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
      
      /*
      function action(){
        var formData = {
          'sent' : 'SUP'
        }
        
        $.ajax({
          url: "rolanderS.php",
          type: "POST", 
          data: formData, 
          dataType: "html"
        })
        .done( function( json ){
          var result = $.parseJSON( json );
          
          $('#not-started').html( "GOT " + result.not_started );
          $('#in-progress').html( "HAVE " + result.in_progress );
          $('#done').html( "RECEIVED " + result.done );
          $('#total').html( "ALL " + result.total );
          $('#response').html( result.response )
          
        });
      }
      */
      
      var status_saved;
      
      window.onload = function(){
        status_saved = '0';
      } 
      
      $(document).ready(function() {
        $(".custom-option").click( function(){          
          $('#selected-text').html( $(this).children(".option-text").text() );
          $('#got-container').html( $(this).children(".option-value").text() );
        });
        
        $("#status-not-started").hover( 
          function(){ status_painter('0', false); },
          function(){ status_painter(status_saved, false); }
        );
        $("#status-in-progress").hover(
          function(){ status_painter('1', false); },
          function(){ status_painter(status_saved, false); }
        );
        $("#status-done").hover(
          function(){ status_painter('2', false); },
          function(){ status_painter(status_saved, false); }
        );
        
      });
          
      function status_painter( status, save ){
        
        if( save ){
          $('#status-update-container').html( status_saved + " TO " + status + " SAVING" );
          status_saved = status;
        }else{
          $('#status-update-container').html( status_saved + " TO " + status );
        }
        
        switch( status ){
          case "0":
            $('#status-bar').css({"background-color": "#d9534f"});
            $('#status-not-started').css({"color": "black"});
            $('#status-in-progress').css({"color": "white"});
            $('#status-done').css({"color": "white"});
            break;
          case '1':
            $('#status-bar').css({"background-color": "#f0ad4e"});
            $('#status-not-started').css({"color": "white"});
            $('#status-in-progress').css({"color": "black"});
            $('#status-done').css({"color": "white"});
            break;
          case '2':
            $('#status-bar').css({"background-color": "#5cb85c"});
            $('#status-not-started').css({"color": "white"});
            $('#status-in-progress').css({"color": "white"});
            $('#status-done').css({"color": "black"});
            break;
          default:
            alert( "WEIRD " + status );
        }
      }
 
    </script>
    
    <style>
      
      .custom-select, .custom-select > button, .custom-select > ul {
        width: 200px;
      }
      
      .custom-select > ul > .custom-option {
        cursor: pointer;
        padding: 2px 0 2px 10px;
      }
      
      .custom-select > ul > .custom-option:hover {
        background-color: #428bca;
        color: white;
      }
      
      .custom-select > ul > .custom-option > .option-value{
        display: none;
      }
    </style>
    
  </head>
  
  <body style="background-color:white; padding:0; margin:0">
    
    <div style="margin-left:5%">
      
      <h1>Rolando&copy; Advanced Systems & Technologies Inc.</h1>
     
      <div>
        <h4>Lab #12: Custom &lt;select&gt;</h4>
        <div>
          <span class="caps-style">RECEIVING:</span>
          <span id="got-container"></span>
        </div>

        <div class="dropdown custom-select">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            <span style="float:left" id="selected-text">Choose...</span>
            <span style="float:right"><span class="caret"></span></span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <li class="custom-option" role="menuitem">
              <span class="option-value">SECRET CODE!</span>
              <span class="option-text">Testing</span>
              <span class="option-extra"> (Lab #2)</span>
            </li>
            <li class="custom-option" role="menuitem">
              <span class="option-value">GOTTA CATCH EM ALL!</span>
              <span class="option-text">Pikachu</span> 
              <span class="option-extra"> (Pokemon)</span>
            </li>
            <li class="custom-option" role="menuitem">
              <span class="option-value">SOMETHING</span>
              <span class="option-text">Something</span>
              <span class="option-extra"> (Huh?)</span>
            </li>
            <li class="custom-option" role="menuitem">
              <span class="option-value">Some really really huge big ginormous amount of data</span>
              <span class="option-text caps-style">LOTS</span>
              <div class="option-extra">
                Putting divs is also fine!
              </div>
            </li>
            <li class="custom-option" role="menuitem">
              <span class="option-value">JUST NO!</span>
              <span class="option-text">No</span>
              <span class="option-extra"> (Uh oh)</span>
            </li>
          </ul>
        </div>
      </div>
        
      <div>
        <h4>Lab #28: Status Selection</h4>
      
        <span class="caps-style">UPDATING: </span><span id="status-update-container"></span>
        <div style="display:table; font-weight:bold;">
          <div id="status-bar" class="form-control" style="background-color:#d9534f; color:white;">
            <span id="status-not-started" style="cursor:pointer; color:black" onclick="status_painter('0', true)">NOT STARTED</span>
            <span style="color:white" class="glyphicon glyphicon-chevron-right"></span>
            <span id="status-in-progress" style="cursor:pointer" onclick="status_painter('1', true)">IN PROGRESS</span>
            <span style="color:white" class="glyphicon glyphicon-chevron-right"></span>
            <span id="status-done" style="cursor:pointer" onclick="status_painter('2', true)">COMPLETED</span>
          </div>
        </div>
          
      </div>
        
    </div>
  </body>
</html>