<?php
  
  // Includes connector.php
  // Includes SESSION validation
  require ( '../../secure/session.php' );

  // Make sure this is invoked by a POST only
  if( isset($_POST) && empty($_GET) ){
    
    if( method_validate( $_POST, ['TDtaskid'] ) ){
      
      action( $_POST['TDtaskid'] );
    }
    header('HTTP/1.1 400 Bad Request');
    exit;
  }

  header('HTTP/1.1 404 Not Found');
  exit;

  function action( $task_id ){
    
    if( $connection = new Connector() ){
      
      if( $Task = $connection->task_getby_id($task_id) ){
        if( $Users = $connection->user_getAll() ){
          paint_modal( $Task, $Users );
          exit;
        }
      }
    }
  }

  // User assignment select
  function user_select( $Task, $Users ){
    
    // Data pull + sanitation
    $default_user_id = $Task->getUserId();
    $default_user_name = $Task->getUserName();
    
    // NO $Object->get() BEYOND THIS POINT

    if( $default_user_id ){
      $default_option = <<< HTML
        <option selected value="$default_user_id">$default_user_name</option>   
HTML;
    }else{
      $default_option = <<< HTML
        <option selected value="">(Not Assigned)</option>   
HTML;
    }
    
    $all_users_option = NULL;
    foreach( $Users as $User ){
      
      // Data pull + sanitation
      $user_name = filter_var($User->getName(), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $user_id = $User->getId();
     
      // NO $Object->get() BEYOND THIS POINT
      
      // TODO: Change <select> to something else
      if( $default_user_id != $user_id ){
        $all_users_option .= <<< HTML
          <option value="$user_id">$user_name</option>     
HTML;
      }
    }
    
    $body = <<< HTML
      <select id="user-select" class="form-control">
        $default_option
        $all_users_option
      </select>
HTML;
    return $body;

  }

  // TODO temporary solution
  // Task status select 
  function status_select( $status){
    
    $options = NULL;
    for( $i = NOT_STARTED; $i <= DONE; ++$i ){
      
      $i == $status ? $selected = "selected" : $selected = NULL;
      
      $string = status_string( $i );
      $options .= <<< HTML
        <option $selected value="$i">$string</option>  
HTML;
    }
    
    $body = <<< HTML
      <select id="status-select" class="form-control">
        $options
      </select>
HTML;
    return $body;
  }

  function status_string( $status ){
    switch( $status ){
      case NOT_STARTED:
        return "NOT STARTED";
      case IN_PROGRESS:
        return "IN PROGRESS";
      case DONE:
        return "DONE";
      default:
        return "ERROR";
    }
  }

  // Formats modal body
  function paint_body( $Task, $Users ){
    
    // Data pull + sanitation
    // Sanitation required, user input
    $name = filter_var($Task->getName(), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($Task->getDescription(), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $client_name = filter_var($Task->getClientName(), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $comment = filter_var($Task->getComment(), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $deadline = filter_var($Task->getDeadline(), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    // Sanitation irrelevant, TINYINT(1) + field made by PHP
    $status = $Task->getStatus();
    $id = $Task->getId();
    $client_id = $Task->getClientId();
    $pinned = $Task->isPinned();
    
    // NO $Object->get() BEYOND THIS POINT
    
    // Name + Pinned
    if( $pinned ){
      $title_span = <<< HTML
        <span id="pin-span" onclick="pin(true, event)" class="glyphicon glyphicon-pushpin pinned"></span> 
        <input name="pinned" type="hidden" value='1'>
        <span class="caps-style">TASK</span>
HTML;
    }else{
      $title_span = <<< HTML
        <span id="pin-span" onclick="pin(false, event)" class="glyphicon glyphicon-pushpin unpinned"></span> 
        <input name="pinned" type="hidden" value='0'>
        <span class="caps-style">TASK</span>
HTML;
    }
    
    // Selects
    $user_input = user_select( $Task, $Users );
    $status_input = status_select( $status );
    
    $body = <<< HTML
      <form id="task-update-form" role="form" onsubmit="task_update( '$id', event)">      
        $title_span
        <input type="text" class="form-control" value="$name" disabled>
      
        <span class="caps-style">PROGRESS & STATUS</span>
        $status_input
      
        <span class="caps-style">CLIENT</span>
        <input type="hidden" value="$client_id">
        <input type="text" class="form-control" value="$client_name" disabled>
      
        <span class="caps-style">DESCRIPTION</span>
        <textarea class="form-control" name="description" style="width:100%" rows="4">$description</textarea>
      
        <span class="caps-style">DEADLINE</span>
        <input name="deadline" class="form-control" type="date" value="$deadline">
      
        <span class="caps-style">ASSIGNED TO</span>
        $user_input

        <span class="caps-style">COMMENT</span>
        <textarea class="form-control" name="comment" style="width:100%" rows="4">$comment</textarea>
      </form>
HTML;
    return $body;
  }

  function paint_modal( $Task, $Users ){
    
    // Data pull + sanitation:
    $name = filter_var($Task->getName(), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = $Task->getId();
    $status = $Task->getStatus();
    
    // NO $Object->get() BEYOND THIS POINT!

    switch( $status ){
      case NOT_STARTED:
        $paneling = '#d9534f';
        break;
      case IN_PROGRESS:
        $paneling = '#f0ad4e';
        break;
      case DONE:
        $paneling = '#5cb85c';
        break;
      default:
        $paneling = NULL;
    }
    
    $header = <<< HTML
      <h4 class="modal-title">$name</h4>
HTML;
    
    $body = paint_body( $Task, $Users );
    
    $footer = <<< HTML
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      <button form="task-update-form" type="submit" class="btn btn-primary">Save changes</button>
HTML;
    
    echo <<< HTML
      <div id="details-modal" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="background-color:$paneling; color:white">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              $header
            </div>
            <div class="modal-body">
              $body
            </div>
            <div class="modal-footer">
              $footer
            </div>
          </div>
        </div>
      </div>
HTML;
  }

?>