<?php
  
  session_start();

  // Include validators
  require ( '../../secure/connector.php' );

  if( isset($_POST) && empty($_GET) ){
    
    if( method_validate( $_POST, ['TDtaskid'] ) ){
      
      action( $_POST['TDtaskid'] );
      
    }
    
  }

  function action( $task_id ){
    
    if( $connection = new Connector() ){
      
      if( $Task = $connection->task_getby_id( $task_id ) ){
        
        paint_modal( $Task );
        header( 'HTTP/1.1 200 OK' );
        exit;
      }
    }
  }

  // Formats modal body
  function paint_body( $Task ){
    $description = $Task->getDescription();
    $comment = $Task->getComment();
    $user = $Task->getUserName();
    $status = $Task->getStatus();
    $id = $Task->getId();
    
    // Name + Pinned
    if( $Task->isPinned() ){
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
    
    $body = <<< HTML
      <form id="task-update-form" role="form" onsubmit="task_update( '$id', event)">      
        $title_span
        <input type="text" class="form-control" value="{$Task->getName()}">
      
        <span class="caps-style">PROGRESS (TODO: Connect UI)</span>
        <div class="progress" style="margin-bottom:0">
          <div class="progress-bar progress-bar-danger progress-bar-striped" style="width: 10%">
            <span class="sr-only">10% Complete (danger)</span>
          </div>
          <div class="progress-bar progress-bar-warning" style="width: 20%">
            <span class="sr-only">20% Complete (warning)</span>
          </div>
          <div class="progress-bar progress-bar-success" style="width: 35%">
            <span class="sr-only">35% Complete (success)</span>
          </div>
        </div>
        <input name="status" type="hidden" value="$status">
      
        <span class="caps-style">CLIENT</span>
        <input type="hidden" value="{$Task->getClientId()}">
        <input type="text" class="form-control" value="{$Task->getClientName()}" disabled>
      
        <span class="caps-style">DESCRIPTION</span>
        <textarea name="description" style="width:100%" rows="3">$description</textarea>
      
        <span class="caps-style">DEADLINE</span>
        <input name="deadline" class="form-control" type="date" value="{$Task->getDeadline()}">
      
        <span class="caps-style">ASSIGNED TO</span>
        <input name="user" class="form-control" type="text" value="$user">
        <input name="userid" type="hidden" value="{$Task->getUserId()}">

        <span class="caps-style">COMMENT</span>
        <textarea name="comment" style="width:100%" rows="3">$comment</textarea>
      </form>
HTML;
    return $body;
  }

  function paint_modal( $Task ){
    
    $name = $Task->getName();
    $id = $Task->getId();
    $status = $Task->getStatus();

    switch( $status ){
      case NOT_STARTED:
        $caption = "NOT STARTED";
        $paneling = '#d9534f';
        break;
      case IN_PROGRESS:
        $caption = "IN PROGRESS";
        $paneling = '#f0ad4e';
        break;
      case DONE:
        $caption = "DONE";
        $paneling = '#5cb85c';
        break;
      default:
        $caption = "ERROR";
        $paneling = NULL;
    }
    
    $header = <<< HTML
      <span style="float:right" class="caps-style">$caption &nbsp;&nbsp;&nbsp;</span>
      <h4 class="modal-title">$name</h4>
HTML;
    
    $body = paint_body( $Task );
    
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
                
      <script>
                
        function pin(isPinned, event){     
          isPinned ? $('input[name=pinned').val('0') : $('input[name=pinned').val('1');
          $('#pin-span').toggleClass('pinned unpinned');     
          event.preventDefault();
        }
    
        function task_update( taskid, event ){

          var formData = {
            'TUFtaskid' : taskid, 
            'TUFpinned' : $('input[name=pinned]').val(),
            'TUFstatus' : $('input[name=status]').val(),
            'TUFdescription' : $('textarea[name=description]').val(),
            'TUFuser' : $('input[name=user]').val(),
            'TUFuserid' : $('input[name=userid]').val(),
            'TUFdeadline' : $('input[name=deadline]').val(),
            'TUFcomment' : $('textarea[name=comment]').val()
          };

          $.ajax({
            url: "/action/task_update.php",
            type: "POST", 
            data: formData, 
            dataType: "html"
          })

          
          .done(function( response ) {
            alert( "OK: " + response );
            $('#details-modal').modal('hide');
            location.reload();
          })
            
          .fail(function( xhr ) {
            alert( "BAD: " + xhr );
          });
          
          event.preventDefault();
        }
                
      </script>
                
HTML;
  }

?>