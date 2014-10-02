<?php

  // Includes connector.php
  // Includes SESSION validation
  require ( '../../secure/session.php' );

  // Includes table maker
  require ( $_SERVER['DOCUMENT_ROOT'] . '/includes/carpenter.php' );

  // Make sure this is invoked by a POST only
  if( isset($_POST) && empty($_GET) ){
    
    // Allow if empty POST
    if( sizeof($_POST) == NULL ){
      action();
    }
  }

  header('HTTP/1.1 404 Not Found');
  exit;

  function action(){
    // Defined by session.php
    global $id;
    global $level;
    
    if( $connection = new Connector() ){
      if( $Tasks = $connection->task_getby_status( $id, $level ) ){

        $List = array(
          TOTAL => array(),
          DONE => array(),
          IN_PROGRESS => array(),
          NOT_STARTED => array()
        );
        
        if( array_key_exists(ALL, $Tasks) ){
          $List[TOTAL] = $Tasks[ALL];

          if( array_key_exists(STATUS, $Tasks) ){
            
            if( array_key_exists(DONE, $Tasks[STATUS]) ){
              $List[DONE] = $Tasks[STATUS][DONE];
            }
            if( array_key_exists(IN_PROGRESS, $Tasks[STATUS]) ){
              $List[IN_PROGRESS] = $Tasks[STATUS][IN_PROGRESS];
            }
            if( array_key_exists(NOT_STARTED, $Tasks[STATUS]) ){
              $List[NOT_STARTED] = $Tasks[STATUS][NOT_STARTED];
            }
          }
        }
                
        $tasks_all = table_make( $List[TOTAL], TRUE );
        $tasks_done = table_make( $List[DONE] );
        $tasks_in_progress = table_make( $List[IN_PROGRESS] );
        $tasks_not_started = table_make( $List[NOT_STARTED] );
        
        // Makes table
        $response = <<< HTML
          <div class="tab-pane" id="tasks-all"> 
            $tasks_all
          </div>
          <div class="tab-pane" id="tasks-done">
            $tasks_done
          </div>
          <div class="tab-pane" id="tasks-in-process">
            $tasks_in_progress
          </div>
          <div class="tab-pane" id="tasks-not-started">
            $tasks_not_started
          </div>
HTML;
        
        $json = array(
          'count' => array(
            'all' => sizeof( $List[TOTAL] ),
            'done' => sizeof( $List[DONE] ),
            'in_progress' => sizeof( $List[IN_PROGRESS] ),
            'not_started' => sizeof( $List[NOT_STARTED] ),
          ),
          'response' => $response
        );
        echo json_encode( $json );
        
        success();
      }
    }
  }

  function success(){
    exit;
  }

?>