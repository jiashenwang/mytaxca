<!DOCTYPE html>
<html lang="en">


      <!-- Bootstrap Core CSS -->
      <link href="css/bootstrap.min.css" rel="stylesheet">

      <!-- Custom CSS -->
      <link href="css/sb-admin.css" rel="stylesheet">

      <!-- Morris Charts CSS -->
      <link href="css/plugins/morris.css" rel="stylesheet">

      <!-- Custom Fonts -->
      <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->

  
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dash.php">My TaxCA</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <b class="caret"></b>Add</a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="tables.php">Create New Task </a>
                        </li>
                      <?php if($level==3) {?>
                        <li>
                            <a href="new_user.php"> Add New Employee</a>
                        </li>                          
                        <?php } ?>                      
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $name ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"> Edit Account</a>
                        </li>
                        <li>
                            <a href="action/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>                      
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="dash.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="charts.php"><i class="fa fa-fw fa-bar-chart-o"></i> Search</a>
                    </li>
                    <li>
                        <a href="tables.php"><i class="fa fa-fw fa-table"></i> New Task</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>  
  
</html>