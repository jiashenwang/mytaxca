<?php
  // Includes connector.php
  // Includes SESSION validation
  require ( '../secure/session.php' );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>My TaxCA - New Employee</title>

    <link href="/assets/css/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  
  <script src="/js/jquery-1.11.0.js"></script>
  <script src="./js/utils.js" type="text/javascript"></script>
  <script src="./js/register_user.js" type="text/javascript"></script>
 
</head>
<body>
    <?php
      include ( $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php' );
      echo navbar();
    ?>
  
    <div id="wrapper">
      <div id="page-wrapper">
        <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Create a New Employee's Account
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="glyphicon glyphicon-dashboard"></i>  <a href="/dashboard.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <span class="glyphicon glyphicon-user"></span> New User Account
                            </li>
                        </ol>
                    </div>
                </div>
              
                <!-- /.row -->
                <div id="user_error" class="alert-box user_error"><span>ERROR: Check the error below</span></div><div id="user_success" class="alert-box user_success"></div>
                <form role="form" method="post" id="addUser" onsubmit="return false;">
                  <div class="form-group">
                    <label for="new_email">New User's Email</label><span id="email_ok"></span>
                    <input required name="new_email" type="email" id="new_email" placeholder="Enter Employee's Email" onchange="checkUserEmail()"> 
                  </div>
                  <div class="form-group">
                    <label for="new_name">New User's Name</label>
                    <input required name="new_name" type="text" class="form-control" id="new_name" placeholder="Enter Employee's Name (First Last)"><span id="name_error" style="color:red"></span>
                </div>
                  
                  <div class="form-group">
                    <label for="initial_pass">New User's Initial Password</label>
                    <input required name="initial_pass" type="password" class="form-control" id="initial_pass"> <span id="pass_error" style="color:red"></span>
                </div>

                <div class="form-group">
                    <label for="new_level">New User's authority level</label>
                    <select required name="new_level" id="new_level">
                      <option value="3">3 (High)</option>
                      <option value="2">2 (Medium)</option>
                      <option value="1">1 (Low)</option>
                    </select>
                </div>
                  <button type="submit" class="btn btn-default" id="register" onclick="addUser()" >Submit</button>
                  <span id="submit_result"></span>
          </form> 
               
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