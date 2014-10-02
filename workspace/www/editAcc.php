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

    <title>My TaxCA - Edit account</title>

    <link href="/assets/css/style.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script src="/js/jquery-1.11.0.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="../js/utils.js" type="text/javascript"></script>
    <script src="../js/editAcc.js" type="text/javascript"></script>
    <script type="text/javascript"></script>
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
                            Edit Account
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <span class="glyphicon glyphicon-dashboard"></span>  <a href="/dashboard.php">Dashboard</a>
                            </li>
                        </ol>
                    </div>
                </div>
   
          
   <form role="form" method="post" id="editUser" onsubmit="return chkOldPass()">
     <div id="user_success" class="alert-box user_success"></div>
     <div id="user_error" class="alert-box user_error"></div>
     <div class="form-group">
       <label for="new_email">USER'S EMAIL</label>
       <input name="new_email" type="email" id="new_email" placeholder="Enter Employee's Email" style="background-color:#FCF5D8; color:#AD8C08" readonly>
     </div>
     <div class="form-group">
        <label for="new_name">NEW USER'S NAME</label>
        <input required name="new_name" type="text" class="form-control" id="new_name" placeholder="Enter Employee's Name (First Last)">
     </div>
     <div class="form-group">
       <label for="old_pass">OLD PASSWORD</label>
       <input required name="old_pass" type="password" class="form-control" id="old_pass">
     </div>
     <div class="form-group">
       <label for="new_ps">NEW PASSWORD</label>
       <input required name="new_ps" type="password" class="form-control" id="new_ps" style="width:30%; height:24px" onchange="passValid()"><span id="pass_error" style="color:red"></span><span id="pass_ok" style="color:green"></span> 
     </div>
     <div class="form-group">
       <label for="confirm_pass">CONFIRM PASSWORD</label>
       <input required name="confirm_pass" type="password" class="form-control" id="confirm_pass" onchange="matchPass()"><span id="conf_error" style="color:red"></span><span id="conf_ok" style="color:green"></span>
     </div>
     <button type="submit" class="btn btn-default" id="register">Submit</button>
   </form>
        </div>
      </div>
  </div>
</body>
        
</html>