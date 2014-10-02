<?php
  // Includes connector.php
  // Includes SESSION validation
  require ( '../secure/session.php' );

  // Includes table maker
  require ( $_SERVER['DOCUMENT_ROOT'] . '/includes/carpenter.php' );

  // Display all tasks
  $Tasks_all = array();
  if( $connection = new Connector() ){
    if( $Tasks = $connection->task_getAll($id, $level) ){
      $Tasks_all = $Tasks;
    }
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

    <title>My TaxCA - Search</title>

    <link href="/assets/css/style.css" rel="stylesheet" type="text/css">

    <script src="/js/jquery-1.11.0.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/task_details.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <script>
      
      function search(event){
        var formData = {
          'Smethod' : $('#method-select :selected').val(),
          'Skeyword' : $('input[name=keyword]').val()
        };
        
        $.ajax({
          url: "/action/search_tasks.php",
          type: "POST", 
          data: formData, 
          dataType: "html"
        })
        .done( function( response ){
          $('#results-container').html( response );
        })
        .fail( function( xhr ){
          alert( "ERROR! Database down" );
        });
        
        event.preventDefault();
      }
      
    </script>    

  </head>

  <body>

    <?php
      include ( $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php' );
      echo navbar( SEARCH );
    ?>
    
    <div id="wrapper">
      <div id="page-wrapper">
        <div class="container-fluid">
          
          <div class="row">
            <div class="col-lg-12">
              <h1 class="page-header">
                Search
              </h1>
              <ol class="breadcrumb">
                <li>
                  <span class="glyphicon glyphicon-dashboard"></span>  <a href="/dashboard.php">Dashboard</a>
                </li>
                <li class="active">
                  <span class="glyphicon glyphicon-search"></span> Search
                </li>
              </ol>
            </div>
          </div>
          
          <ul id="search-tab" class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#tasks-search" role="tab" data-toggle="tab">Search Tasks</a></li>
            <li><a href="#tasks-all" role="tab" data-toggle="tab">Show All Tasks</a></li>
          </ul>

          <div class="tab-content">
            <div class="tab-pane active" id="tasks-search">
              <form class="navbar-form navbar-left" role="search" onsubmit="search(event)" style="width:100%; padding-left:10px">

                <div class="form-group">
                  <label for="method-select" class="caps-style">SEARCH BY </label>
                  <select class="form-control" id="method-select">
                    <option value="1">Task Name</option>
                    <option value="2">Client Name</option>
                    <option value="3">Client Company</option>
                    <?php if( $level == OWNER ) { ?>
                    <option value="4">Employee Name</option>
                    <?php } ?>
                  </select>
                </div>                
                
                <div class="input-group" style="width:30%">
                  <input name="keyword" type="text" class="form-control" placeholder="Keyword" required>
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Search</button>
                  </span>
                </div>
              </form>   
              
              <div id="results-container"></div>
              
            </div>   

            <div class="tab-pane" id="tasks-all"> 
              <?= table_make( $Tasks_all, TRUE ); ?>
            </div>
          </div>
          
        </div>
      </div>
    </div>
    
    <div id="modal-container"></div>
    
  </body>

</html>
