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

    <title>My TaxCA - New Client</title>

    <link href="/assets/css/style.css" rel="stylesheet" type="text/css">
  
    <script src="/js/jquery-1.11.0.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
      
      
      function client(event){
        

        var formData = {
          'entered_new_client_name' : $('input[name=new_client_name]').val(),
          'entered_new_client_type' : $("input[name=new_client_type]:checked").val(),
          'entered_new_client_company' : $('input[name=new_client_company]').val(),
          'entered_new_client_address' : $('input[name=new_client_address]').val(),
          'entered_new_client_email' : $('input[name=new_client_email]').val(),
          'entered_new_client_phone' : $('input[name=new_client_phone]').val()
        };

        // Create our ajax requests
        $.ajax({
          url: "/action/client.php",
          type: "POST", 
          data: formData, 
          dataType: "html"
        })
        
        // Success, redirect
        .done(function() {
          alert("New Client added!");
          //window.location = "thanks.php";
        })

        // Failed, check status code
        .fail(function( xhr ) {
          alert('adding Customer field!');
        });    
        
        event.preventDefault();
      }
    </script>  


</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
    <?php
      include ( $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php' );
      echo navbar();
    ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Create a New Client's Profile
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <span class="glyphicon glyphicon-dashboard"></span>  <a href="/dashboard.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> New Client Profile
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <form role="form" onsubmit="client(event)">
                  <div class="form-group">
                    <label for="new_client_name">New Client's Name</label><span class="red-star">★</span>
                    <input required name="new_client_name" type="text" class="form-control" id="new_client_name" placeholder="Enter New Client's Name">
                  </div>
                  
                  <div class="form-group">
                    <input checked="checked" id="individual" type="radio" name="new_client_type" value=1> Individual<br>
                    <input id="company" type="radio" name="new_client_type" value=0> Company
                </div>
                  
                <div class="form-group">
                    <label for="new_client_company">New Client's Company Name</label>
                    <input name="new_client_company" type="text" class="form-control" id="new_client_company" placeholder="Enter New Client's company Name">
                </div>               
                  
                  <div class="form-group">
                    <label for="new_client_address">New Client's Address</label>
                    <input name="new_client_address" type="text" class="form-control" id="new_client_address" placeholder="Enter New Client's address">
                </div>

                  <div class="form-group">
                    <label for="new_client_email">New Client's Email</label>
                    <input name="new_client_email" type="email" class="form-control" id="new_client_email" placeholder="Enter New Client's email">
                </div>

                  <div class="form-group">
                    <label for="new_client_phone">New Client's Phone number</label>
                    <input name="new_client_phone" type="text" class="form-control" id="new_client_phone" placeholder="Enter New Client's Phone Number">
                </div>                  


                  <button type="submit" class="btn btn-default">Submit</button>
                </form>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


</body>

</html>