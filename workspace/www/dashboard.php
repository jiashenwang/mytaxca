<?php
  // Includes connector.php
  // Includes SESSION validation
  require ( '../secure/session.php' );

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>My TaxCA</title>

    <link href="/assets/css/style.css" rel="stylesheet" type="text/css">

    <script src="/js/jquery-1.11.0.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/task_details.js"></script>
    
    <script>

      window.onload = function(){
        table_make();
      } 
      
      function table_make(){
        $.ajax({
          url: "/action/task_dashboard.php",
          type: "POST",
          dataType: "html"
        })
        .done(function( json ){          
          var object = $.parseJSON( json );
          
          $('#all-counter').html( object.count.all );
          $('#done-counter').html( object.count.done );
          $('#in-progress-counter').html( object.count.in_progress );
          $('#not-started-counter').html( object.count.not_started );
          $('#tasks-container').html( object.response );
          
          // Maintains current tab          
          $( $("#tasks-tab .active a").attr("href") ).addClass('active');
        })
        .fail(function( xhr ){
          alert( "ERROR! Database down" );
        });
      }
      
      function table_show( index, event ){
        $('#tasks-tab li:eq(' + index + ') a').tab('show');
      }
            
    </script>

  </head>

  <body>
  
    <?php
      include ( $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php' );
      echo navbar( DASHBOARD );
    ?>

    <div id="wrapper">
      <div id="page-wrapper">
        <div class="container-fluid">
          
          <div class="row">
            <div class="col-lg-12">
              <h1 class="page-header">
                Dashboard <small> Overview</small>
              </h1>
              <ol class="breadcrumb">
                <li class="active">
                  <span class="glyphicon glyphicon-dashboard"></span> Dashboard
                </li>
              </ol>
            </div>
          </div>

          <h4> Tasks this month </h4>
          <div class="row">
            <div class="col-lg-3 col-md-6">
              <div class="panel panel-primary">
                <div onclick="table_show('0', event)" style="cursor:pointer" class="panel-heading ph-rewrite">
                  <div class="row">
                    <div class="col-xs-3">
                      <span class="glyphicon glyphicon-globe dash-icon"></span>
                    </div>
                    <div class="col-xs-9 text-right">
                      <div class="huge" id="all-counter">0</div>
                      <div>Total Tasks</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6">
              <div class="panel panel-green">
                <div onclick="table_show('1', event)" style="cursor:pointer" class="panel-heading ph-rewrite">
                  <div class="row">
                    <div class="col-xs-3">
                      <span class="glyphicon glyphicon-ok-circle dash-icon"></span>
                    </div>
                    <div class="col-xs-9 text-right">
                      <div class="huge" id="done-counter">0</div>
                      <div>Done!</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6">
              <div class="panel panel-yellow">
                <div onclick="table_show('2', event)" style="cursor:pointer" class="panel-heading ph-rewrite">
                  <div class="row">
                    <div class="col-xs-3">
                      <span class="glyphicon glyphicon-exclamation-sign dash-icon"></span>
                    </div>
                    <div class="col-xs-9 text-right">
                      <div class="huge" id="in-progress-counter">0</div>
                      <div>In Progress!</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6">
              <div class="panel panel-red">
                <div onclick="table_show('3', event)" style="cursor:pointer" class="panel-heading ph-rewrite">
                  <div class="row">
                    <div class="col-xs-3">
                      <span class="glyphicon glyphicon-ban-circle dash-icon"></span>
                    </div>
                    <div class="col-xs-9 text-right">
                      <div class="huge" id="not-started-counter">0</div>
                      <div>Not Started!</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <h4>Tasks by status</h4>
          <ul id="tasks-tab" class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#tasks-all" role="tab" data-toggle="tab">All Tasks</a></li>
            <li><a href="#tasks-done" role="tab" data-toggle="tab">Finished</a></li>
            <li><a href="#tasks-in-process" role="tab" data-toggle="tab">In Progress</a></li>
            <li><a href="#tasks-not-started" role="tab" data-toggle="tab">Not Started</a></li>
          </ul>

          <div class="tab-content" id="tasks-container"></div>
        </div>
      </div>
    </div>
    
    <div id="modal-container"></div>

  </body>

</html>
