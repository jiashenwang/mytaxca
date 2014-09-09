<?php

session_start();

if (isset($_SESSION['email'])) {
	// Put stored session variables into local PHP variable
	$email = $_SESSION['email'];
	$name = $_SESSION['name'];
  $level = $_SESSION['level'];
  
  echo $_SESSION['id'];
  unset($_SESSION['id']);
  
  
} else {
	header("Location: index.php");
}

// receive request
if($_SERVER["REQUEST_METHOD"] == "POST" ){
  
    $entered_task_name = $_POST["task_name"];
    $entered_client_name = $_POST["client_name"];
    $entered_company_name = $_POST["company_name"];
    $entered_client_address = $_POST["client_address"];
    $entered_client_email = $_POST["client_email"];
    $entered_client_phone = $_POST["client_phone"];
    $entered_job_description = $_POST["job_description"];
    if($level == 3){
      $entered_assign_to = $_POST["assign_to"];
    }
    else
    {
      $entered_assign_to="";
    }
    $entered_deadline = $_POST["deadline"];
    $entered_memo = $_POST["memo"];
    $entered_status = "not_start";
    $entered_id = uniqid();
  
  // try to connect server
    try{
    $db = new PDO('mysql:host=localhost;dbname=mytaxca;charset=utf8','root', '123456');
    $db->exec("SET NAMES 'utf8'");
  } catch (Exception $e){
    echo "fail to connect to server.";
      exit;
  }  
  
  // put value into db
     try{
      $result = $db->prepare("INSERT INTO tasks (task_name, client_name, company_name, client_address, client_email, client_telephone, job_description, assign_to, deadline, memo, status, id) VALUES('$entered_task_name','$entered_client_name', '$entered_company_name', '$entered_client_address', '$entered_client_email', '$entered_client_phone', '$entered_job_description', '$entered_assign_to', '$entered_deadline', '$entered_memo', '$entered_status', '$entered_id');");
      $result->execute();
       
      // this session tells thanks page what to show 
      $_SESSION['action'] = 'add_task'; 
       
      header("Location: thanks.php");
    } catch (Exception $e){
      echo "cannot insert data to server!";
      exit;
    }  


    header("Location: thanks.php");  
}
// eding receiving request

// connect to db
try{
    $db = new PDO('mysql:host=localhost;dbname=mytaxca;charset=utf8','root', '123456');
    $db->exec("SET NAMES 'utf8'");
  } catch (Exception $e){
    echo "fail to connect to server.";
      exit;
  }

// fetch data
  try{
    $result = $db->query("SELECT name FROM users;");
    $row = $result->fetchAll();
    //var_dump($row);  
  } catch (Exception $e){
    echo "cannot get all users from server!";
    exit;
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
f
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

        <script>

            function validateForm() {
                var x = document.getElementById("customer_name").value;
                var y = document.getElementById("deadline").value;

                x = x.replace(/\s/g, '');
                y = y.replace(/\s/g, '');



                if (x.length==0 || y.length==0) {
                    alert("Not valid customer name or deadline");
                    return false;
                }
                else
                {
                    return true;
                }
            }

        </script>

</head>

<body>

    <div id="wrapper">

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
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $name ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"> Edit Account</a>
                        </li>                      
                        <li>
                            <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="dash.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="charts.php"><i class="fa fa-fw fa-bar-chart-o"></i> Search</a>
                    </li>
                    <li class="active">
                        <a href="tables.php"><i class="fa fa-fw fa-table"></i> New Task</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Task Detail and Modify
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
                <form role="form" method="post" action="tables.php" onsubmit="return validateForm();">
                  <div class="form-group">
                    <label for="task_name">Task Name <span class="red-star">★</span></label> 
                    <input required name="task_name" type="text" class="form-control" id="task_name" placeholder="Enter Task Name">
                  </div>
                  <div class="form-group">
                    <label for="client_name">Client Name <span class="red-star">★</span></label>
                    <input required name="client_name" type="text" class="form-control" id="client_name" placeholder="Enter Client's Name (First Last)">
                </div>
                  
                  <div class="form-group">
                    <label for="company_name">Company Name</label>
                    <input name="company_name" type="text" class="form-control" id="company_name" placeholder="Enter Company Name">
                </div> 
                  
                  <div class="form-group">
                    <label for="client_address">Client's Address</label>
                    <input name="client_address" type="text" class="form-control" id="client_address" placeholder="Enter Client's Address">
                </div>  
                  
                  <div class="form-group">
                    <label for="client_email">Client's Email</label>
                    <input name="client_email" type="text" class="form-control" id="client_email" placeholder="Enter Client's Email">
                </div>
                  
                  <div class="form-group">
                    <label for="client_phone">Client's Phone Number</label>
                    <input name="client_phone" type="text" class="form-control" id="client_phone" placeholder="Enter Client's Phone Number">
                </div> 
                  
                  <div class="form-group">
                    <label for="job_description">Job Description</label>
                    <input name="job_description" type="text" class="form-control wide-window" id="job_description" placeholder="Job Description">
                </div>                   
                  
                    <div class="form-group" <?php if($level != 3) { ?> hidden <?php } ?> >
                      <label for="assign_to">Assign to <span class="red-star">★</span></label>   
                      <select name="assign_to" class="form-control" id="assign_to" placeholder="person who will be responsible for the task">
                        <?php
                              foreach ($row as $person) { ?>
                        <option value= <?php echo $person["name"]; ?> > <?php echo $person["name"]; ?> </option>
                        <?php } ?>
                      </select>                    
                  </div>

                <div class="form-group">
                    <label for="deadline">Deadline<span class="red-star">★</span></label>
                    <input required name="deadline" type="date" class="form-control" id="deadline" >
                </div>

                <div class="form-group">
                    <label for="memo">Memo</label>
                    <textarea name="memo" rows="4" cols="50" class="form-control" id="memo"></textarea>
                </div>

                  <button type="submit" class="btn btn-default">Modify</button>
                </form>
            
              <a href="dash.php"><button class="btn btn-default">Back</button></a>      

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