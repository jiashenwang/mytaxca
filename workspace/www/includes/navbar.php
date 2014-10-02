<?php

  // Paints navbar
  // $page   - URI page calling navbar (ie: dash.php, etc) 
  function navbar( $page = NULL ){
    global $level;
    global $name;
    
    // <li> add employee
    $add_employee_li = NULL;
    if( $level == OWNER ){
      $add_employee_li = <<< HTML
        <li><a href="/new_user.php"> Add New Employee</a></li>                       
HTML;
    }
    
    // <div> sidebar
    // Marks calling page as active
    $sidebar_div = active_sidebar( $page );
    
    // echo navbar, uses PHP Heredocs
    echo <<< HTML
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
          </button>
          <a class="navbar-brand" href="/dashboard.php">My TaxCA</a>
        </div>

        <ul class="nav navbar-right top-nav">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <b class="caret"></b>Add</a>
            <ul class="dropdown-menu alert-dropdown">
              <li><a href="/new_task.php">Create New Task </a></li>
              <li><a href="/new_client.php"> Add New Client</a></li>            
              $add_employee_li     
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> $name <b class="caret"></b></a>
            <ul class="dropdown-menu">    
              <li><a href="/editAcc.php"> Edit Account</a></li>
              <li><a href="/action/logout.php"><span class="glyphicon glyphicon-off"></span> Log Out</a></li>                      
            </ul>
          </li>
        </ul>

        $sidebar_div
      </nav>  
HTML;
  }

  // Highlights sidebar
  function active_sidebar( $page ){
    $dashboard = NULL;
    $search = NULL;
    $new_task = NULL;
    
    // Creates class tag for <li>, uses PHP Heredocs
    $class = <<< HTML
      class="active" 
HTML;
    
    switch( $page ){
      case DASHBOARD:
        $dashboard = $class;
        break;
      case SEARCH:
        $search = $class;
        break;
      case NEW_TASK:
        $new_task = $class;
        break;     
    }
    
    // Paints sidebar, uses PHP Heredocs
    $body = <<< HTML
      <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
          <li $dashboard ><a href="/dashboard.php"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a></li>
          <li $search ><a href="/search.php"><span class="glyphicon glyphicon-search"></span> Search</a></li>
          <li $new_task ><a href="/new_task.php"><span class="glyphicon glyphicon-record"></span> New Task</a></li>
        </ul>
      </div>
HTML;
    return $body;
  }
?>  