
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>My TaxCA - New Employee</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
f
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

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
                            Create a New Employee's Account
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="dash.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> New User Account
                            </li>
                        </ol>
                    </div>
                </div>
               <?php if($repeat == true) { ?>
                <h5 style="background-color:red;">Email or name has already been used</h5>
               <?php } ?>
                <!-- /.row -->
                <form role="form" method="post" action="new_user.php">
                  <div class="form-group">
                    <label for="new_email">New User's Email</label>
                    <input required name="new_email" type="email" class="form-control" id="new_email" placeholder="Enter Employee's Email">
                  </div>
                  <div class="form-group">
                    <label for="new_name">New User's Name</label>
                    <input required name="new_name" type="text" class="form-control" id="new_name" placeholder="Enter Employee's Name (First Last)">
                </div>
                  
                  <div class="form-group">
                    <label for="initial_pass">New User's Initial Password</label>
                    <input required name="initial_pass" type="password" class="form-control" id="initial_pass">
                </div>

                <div class="form-group">
                    <label for="new_level">New User's authority level</label>
                    <select required name="new_level" id="new_level">
                      <option value="3">3 (Heigh)</option>
                      <option value="2">2 (Medium)</option>
                      <option value="1">1 (Low)</option>
                    </select>
                </div>


                  <button type="submit" class="btn btn-default">Submit</button>
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