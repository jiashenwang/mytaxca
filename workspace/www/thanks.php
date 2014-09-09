<?php
session_start();
 
if (isset($_SESSION['email'])) {
	// Put stored session variables into local PHP variable
	$email = $_SESSION['email'];
	$name = $_SESSION['name'];
  $level = $_SESSION['level'];
  $action = $_SESSION['action'];
} else {
	header("Location: index.php");
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

    <title>My TaxCA - New Task</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

        <script>

            function validateForm() {
                var x = document.getElementById("customer").value;
                var y = document.getElementById("deadline").value;

                x = x.replace(/\s/g, '');
                y = y.replace(/\s/g, '');



                if (x.length==0 || y.length==0) {
                    alert("Not valid customer name or deadline");
                    return false;
                }
            }

        </script>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
   <?php
      include 'nav_bar.php';
  ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Create a New Task
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="dash.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> New Task
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i> Great! <?php if($action=='add_task') { ?> Task <?php } else if($action=='add_user') { ?> Account <?php } ?> added! <img class=icons src="/assets/images/check.png" width="16" height="16">
                            </li>
                        </ol>
                    </div>
                </div>


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>