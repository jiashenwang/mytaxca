<?php
  
  // Includes connector.php
  // Includes SESSION validation
  require ( '../secure/session.php' );

  $Tasks_not_started = array();
  $Tasks_in_process = array();
  $Tasks_done = array();
  $Tasks_all = array();

  // TODO DEBUG delete this
  $debug = "DEBUG: all good";

  if( $connection = new Connector() ){
    if( $Tasks_list = $connection->task_getby_status( $id, $level ) ){
      
      if( array_key_exists( NOT_STARTED, $Tasks_list ) ){
        $Tasks_not_started = $Tasks_list[NOT_STARTED];
        $Tasks_all = array_merge( $Tasks_all, $Tasks_not_started );
      }
      
      if( array_key_exists( IN_PROGRESS, $Tasks_list ) ){
        $Tasks_in_progress = $Tasks_list[IN_PROGRESS];
        $Tasks_all = array_merge( $Tasks_all, $Tasks_in_progress );
      }
      
      if( array_key_exists( DONE, $Tasks_list ) ){
        $Tasks_done = $Tasks_list[DONE];
        $Tasks_all = array_merge( $Tasks_all, $Tasks_done );
      }
      
    }
  }

  function table_header( $status_show = FALSE ){
    
    // Show status
    if( $status_show ){
      $difference_td = <<< HTML
        <th class="caps-style" style="width:10%">STATUS</th>
        <th class="caps-style" style="width:20%">COMMENT</th> 
HTML;
    }else{
      $difference_td = <<< HTML
        <th class="caps-style" style="width:30%">COMMENT</th> 
HTML;
    }
    
    // Common headers
    $body = <<< HTML
      <tr>
        <th class="caps-style" style="width:15%">NAME</th>
        <th class="caps-style" style="width:25%">DESCRIPTION</th>
        <th class="caps-style" style="width:10%">CLIENT</th> 
        <th class="caps-style" style="width:10%">DEADLINE</th>
        <th class="caps-style" style="width:10%">ASSIGNED TO</th>
        $difference_td
      </tr>
HTML;
    return $body;
  }

  function table_body( $Tasks_list, $status_show = FALSE ){
        
    $body = NULL;
    $status_td = NULL;
    foreach( $Tasks_list as $Task ){
      
      if( $status_show ){
        $status_td = status_display( $Task );
      }
      
      date_default_timezone_set('US/Pacific');
      $deadline_td = date_display( $Task->getDeadline() );
      
      $task_id = $Task->getId();
      $task_name = $Task->getName();
      $task_description = $Task->getDescription();
      $task_client = $Task->getClientName();
      $task_user = $Task->getUserName();
      $task_comment = $Task->getComment();
      
      $pin = NULL;
      if( $Task->isPinned() ){
        $pin = <<< HTML
          <span class="glyphicon glyphicon-pushpin"></span>&nbsp;
HTML;
      }
      
      $body .= <<< HTML
        <tr id="$task_id" style="cursor:pointer" onclick="task_details('$task_id', event)">
          <td class="longtext" title="$task_name">$pin$task_name</td>
          <td class="longtext" title="$task_description">$task_description</td>
          <td class="longtext" title="$task_client">$task_client</td>
          $deadline_td
          <td class="longtext" title="$task_user">$task_user</td>
          $status_td
          <td class="longtext" title="$task_comment">$task_comment</td>
        </tr>
HTML;
    }
    return $body;
  }

  function date_display( $timestamp ){
    
    $date = strtotime($timestamp);
    $mdy = date('M d Y', $date);
    
    $body = <<< HTML
      <td>
        <span class="caps-style" style="text-transform:uppercase">$mdy</span>
      </td>
HTML;
    return $body;
  }

  function status_display( $Task ){
    $string = NULL;
    switch( $Task->getStatus() ){
      case NOT_STARTED:
        $string = "NOT STARTED";
        break;
      case IN_PROGRESS:
        $string = "IN PROGRESS";
        break;
      case DONE:
        $string = "DONE";
        break;
      default:
        $string = "ERROR";
    }
    
    $body = <<< HTML
      <td>
        <span class="caps-style">$string</span>
      </td>
HTML;
    return $body;
  }

  function table_make( $Tasks_list, $status_show = FALSE ){
    
    $headers = table_header( $status_show );
    $details = table_body( $Tasks_list, $status_show );
    
    $body = NULL;
    if( sizeof($Tasks_list) ){
      $body = <<< HTML
        <div>
          <div class="table-responsive">
            <table class="table" style="width=100%; table-layout:fixed">
              <thead>
                $headers
              </thead>
              <tbody>
                $details
              </tbody>
            </table>   
          </div>
        </div>
HTML;
    }else{
      $body = <<< HTML
        <div style="margin:5px 0 5px 10px">
          <span style="font-weight:bold; font-size:85%">NOTHING IS HERE</span>
        </div>
HTML;
    }
    return $body;
  }
    

  
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

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script src="/js/jquery-1.11.0.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    
    <script>
      
      function task_details( task_id, event ){
        
        var formData = {
          'TDtaskid' : task_id
        };

        // Create our ajax requests
        $.ajax({
          url: "/action/details.php",
          type: "POST", 
          data: formData, 
          dataType: "html"
        })
        
        // Success, redirect
        .done(function( response ) {          
          $('#modal-container').html( response );
          $('#details-modal').modal('show');
        })

        // Failed, check status code
        .fail(function( xhr ) {

        });    
        
        event.preventDefault();
      }
      
    </script>

  </head>

  <body>
  
    <?php
      include ( $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php' );
      echo navbar( $_SESSION['info'], DASHBOARD );
    ?>

    <div id="wrapper">
      <div id="page-wrapper">
        <div class="container-fluid">
          
          <h1><?= $debug ?></h1>
          
          <!-- Page Heading -->
          <div class="row">
            <div class="col-lg-12">
              <h1 class="page-header">
                Dashboard <small> Overview</small>
              </h1>
              <ol class="breadcrumb">
                <li class="active">
                  <i class="fa fa-dashboard"></i> Dashboard
                </li>
              </ol>
            </div>
          </div>

          <!-- /.row -->
          <h4> Tasks this month </h4>
          <div class="row">
            <div class="col-lg-3 col-md-6">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <div class="row">
                    <div class="col-xs-3">
                      <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <div class="huge">
                        <?= sizeof($Tasks_all) ?>
                      </div>
                      <div>Total Tasks</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6">
              <div class="panel panel-green">
                <div class="panel-heading">
                  <div class="row">
                    <div class="col-xs-3">
                      <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <div class="huge"> 
                        <?= sizeof($Tasks_done) ?> 
                      </div>
                      <div>Done!</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6">
              <div class="panel panel-yellow">
                <div class="panel-heading">
                  <div class="row">
                    <div class="col-xs-3">
                      <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <div class="huge"> 
                        <?= sizeof($Tasks_in_process) ?> 
                      </div>
                      <div>In Progress!</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6">
              <div class="panel panel-red">
                <div class="panel-heading">
                  <div class="row">
                    <div class="col-xs-3">
                      <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <div class="huge"> 
                        <?= sizeof($Tasks_not_started) ?> 
                      </div>
                      <div>Not Started!</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->

          <h4>Tasks by Status</h4>
          <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#tasks_all" role="tab" data-toggle="tab">All Tasks</a></li>
            <li><a href="#tasks_done" role="tab" data-toggle="tab">Finished</a></li>
            <li><a href="#tasks_in_process" role="tab" data-toggle="tab">In Progress</a></li>
            <li><a href="#tasks_not_started" role="tab" data-toggle="tab">Not Started</a></li>
          </ul>

          <div class="tab-content">
            <div class="tab-pane active" id="tasks_all"> 
              <?php
                echo table_make( $Tasks_all, TRUE );
              ?>
            </div>
            <div class="tab-pane" id="tasks_done">
              <?php
                echo table_make( $Tasks_done );
              ?>
            </div>
            <div class="tab-pane" id="tasks_in_process">
              <?php
                echo table_make( $Tasks_in_process );
              ?>
            </div>
            <div class="tab-pane" id="tasks_not_started">
              <?php
                echo table_make( $Tasks_not_started );
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div id="modal-container"></div>

  </body>

</html>
