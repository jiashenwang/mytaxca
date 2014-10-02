<?php
  // Includes connector.php
  // Includes SESSION validation
  require ( '../secure/session.php' );

  $Tasks_not_started = array();
  $Tasks_in_progress = array();
  $Tasks_done = array();
  $Tasks_all = array();

  if( $connection = new Connector() ){
    if( $Tasks = $connection->task_getby_status( $id, $level ) ){
      
      // Task array assignments
      $Tasks_all = $Tasks[ALL];

      if( array_key_exists( NOT_STARTED, $Tasks[STATUS] ) ){
        $Tasks_not_started = $Tasks[STATUS][NOT_STARTED];
      }
      
      if( array_key_exists( IN_PROGRESS, $Tasks[STATUS] ) ){
        $Tasks_in_progress = $Tasks[STATUS][IN_PROGRESS];
      }
      
      if( array_key_exists( DONE, $Tasks[STATUS] ) ){
        $Tasks_done = $Tasks[STATUS][DONE];
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
      
      // Data pulling + sanitation
      // Sanitation required, user input
      $task_name = filter_var($Task->getName(), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $task_description = filter_var($Task->getDescription(), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $task_client = filter_var($Task->getClientName(), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $task_user = filter_var($Task->getUserName(), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $task_comment = filter_var($Task->getComment(), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $task_deadline = filter_var($Task->getDeadline(), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      
      // Sanitation optional, field made by PHP
      $task_id = $Task->getId();
      
      // Sanitation irrelevant, TINYINT(1) + field made by PHP
      $task_status = $Task->getStatus();
      $task_pinned = $Task->isPinned();
      
      date_default_timezone_set('US/Pacific');
      $deadline_td = date_display( $task_deadline );
      
      $status_class = NULL;
      if( $status_show ){
        $status_td = status_display( $task_status );
        if( $task_status == DONE ){
          $status_class = "status-done";
        }
      }
         
      $pin = NULL;
      if( $task_pinned ){
        $pin = <<< HTML
          <span class="glyphicon glyphicon-pushpin"></span>&nbsp;
HTML;
      }
      
      $body .= <<< HTML
        <tr id="$task_id" class="$status_class" style="cursor:pointer" onclick="task_details('$task_id', event)">
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

  function status_display( $status ){
 
    $string = NULL;
    switch( $status ){
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

    <link href="/assets/css/style.css" rel="stylesheet" type="text/css">
    
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script src="/js/jquery-1.11.0.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    
    
    
    <script>
      
      function table_show( index, event ){
        $('#tasks-tab li:eq(' + index + ') a').tab('show');
      }
      
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
                <div onclick="table_show('0', event)" style="cursor:pointer" class="panel-heading">
                  <div class="row">
                    <div class="col-xs-3">
                      <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <div class="huge" id="all-counter">
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
                <div onclick="table_show('1', event)" style="cursor:pointer" class="panel-heading">
                  <div class="row">
                    <div class="col-xs-3">
                      <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <div class="huge" id="done-counter"> 
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
                <div onclick="table_show('2', event)" style="cursor:pointer" class="panel-heading">
                  <div class="row">
                    <div class="col-xs-3">
                      <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <div class="huge" id="in-progress-counter"> 
                        <?= sizeof($Tasks_in_progress) ?> 
                      </div>
                      <div>In Progress!</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6">
              <div class="panel panel-red">
                <div onclick="table_show('3', event)" style="cursor:pointer" class="panel-heading">
                  <div class="row">
                    <div class="col-xs-3">
                      <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <div class="huge" id="not-started-counter"> 
                        <?= sizeof($Tasks_not_started) ?> 
                      </div>
                      <div>Not Started!</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <h4>Tasks by status</h4>
          <ul id="tasks-tab" class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#tasks_all" role="tab" data-toggle="tab">All Tasks</a></li>
            <li><a href="#tasks_done" role="tab" data-toggle="tab">Finished</a></li>
            <li><a href="#tasks_in_process" role="tab" data-toggle="tab">In Progress</a></li>
            <li><a href="#tasks_not_started" role="tab" data-toggle="tab">Not Started</a></li>
          </ul>

          <div class="tab-content" id="task-tables">
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
                echo table_make( $Tasks_in_progress );
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
