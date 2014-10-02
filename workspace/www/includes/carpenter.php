<?php

  // MAIN FUNCTIONS

  // Makes table
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
      $body = failure();
    }
    return $body;
  }

  // HELPER AND SUPPORT FUNCTIONS

  function failure(){
    $body = <<< HTML
      <div style="margin:5px 0 5px 10px">
        <span style="font-weight:bold; font-size:85%">NOTHING IS HERE</span>
      </div>
HTML;
    return $body;
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
        switch( $task_status ){
          case DONE:
            $status_class = "status-done";
            break;
          case IN_PROGRESS:
            $status_class = "status-in-progress";
            break;
          default:
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
?>