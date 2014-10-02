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

    <title>My TaxCA - New Task</title>

    <link href="/assets/css/style.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

    <script src="/js/jquery-1.11.0.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script> 
      $(function(){
        $("#includedContent").load("new_client.php #page-wrapper"); 
      }); 

      var clientChoosed = false;
      var client_id;
      var client_name;
      var count=0;
      var name_list;

      
          // get users
          $.ajax({
            url: "/action/task_user.php",
            type: "GET", 
          })

          // Success, shoot stuff
          .done(function( data ) {
            //alert(data);
            result = JSON.parse(data);
            name_list = result;
            var select = document.getElementById('assign_to');

            
            for (i = 0; i<=result.length-1; i++){
                var opt = document.createElement('option');
                opt.value = result[i].user_id;
                opt.name = result[i].user_name;
                opt.innerHTML = result[i].user_name;
                select.appendChild(opt);
            }
          })       
          // Failed, also shoot stuff
          .fail(function(xhr, status, error) {
          });  
      
      
      function client(event){
        
        var formData = {
          'entered_new_client_name' : $('input[name=new_client_name]').val(),
          'entered_new_client_type' : $("input[name=new_client_type]:checked").val(),
          'entered_new_client_company' : $('input[name=new_client_company]').val(),
          'entered_new_client_address' : $('input[name=new_client_address]').val(),
          'entered_new_client_email' : $('input[name=new_client_email]').val(),
          'entered_new_client_phone' : $('input[name=new_client_phone]').val()
        };
        
        var entered_client_name = $('input[name=new_client_name]').val();
        var entered_client_company = $('input[name=new_client_company]').val();
        var entered_client_phone = $('input[name=new_client_phone]').val();
        var entered_client_address = $('input[name=new_client_address]').val();

        // Create our ajax requests
        $.ajax({
          url: "/action/client.php",
          type: "POST", 
          data: formData, 
          dataType: "html"
        })
        
        // Success, redirect
        .done(function(data) {      
          
          client_id = JSON.parse(data);
          client_name = entered_client_name;
          clientChoosed=true;
          
          document.getElementById("client_name").value = entered_client_name;
          document.getElementById("client_company").value = entered_client_company;
          document.getElementById("client_phone").value = entered_client_phone;
          document.getElementById("client_address").value = entered_client_address;
      
          
         alert("New Client Added!");
        
          //window.location = "thanks.php";
        })

        // Failed, check status code
        .fail(function( xhr ) {
          alert('adding Customer field!');
        });    
        
        event.preventDefault();
      }
      
      function showResult(value){
       
        //$('.guess_clients').remove();
        
            
            // get the child element node
        for(i=0; i<count; i++){
            var child = document.getElementById('guess_clients');
            if(child){
                child.parentNode.removeChild(child); 
            }             
        }
        document.getElementById("livesearch").innerHTML=""; 
        
        var formData = {
          'q' : value
        };

        // Create our ajax requests
        $.ajax({
          url: "/action/search_client.php",
          type: "POST", 
          data: formData, 
          dataType: "html"
        })
        
        // Success, redirect
        .done(function(data) {      
                 
          result = JSON.parse(data);
          count = result.length+1;
          console.log(result);
           //document.getElementById("livesearch").style.border="1px solid #A5ACB2";
          
          if(result.length >= 1 ){           
            
            var i, newButton;
            buttonContainer = document.getElementById('livesearch');
            for (i = 0; i < result.length; i++){
                
                newButton = document.createElement('input');
                newButton.type = 'button';
                if(result[i]['client_type'] == 0){
                  newButton.value = result[i]['client_name']+" (Company:  "+result[i]['client_company']+" )";                  
                }else{
                  newButton.value = result[i]['client_name']+" (Invidual)";
                }

                newButton.id = 'guess_clients';
                newButton.client_id=result[i]['client_id'];
                newButton.company=result[i]['client_company'];
                newButton.phone=result[i]['client_phone']
                newButton.address=result[i]['client_address']
                newButton.name=result[i]['client_name']
                
                newButton.onclick = function () {
                 
                  
                  document.getElementById("search_client").value = this.name;
                  
                 //var elem = document.getElementById('notice');
                  elem_err.style.visibility = 'hidden';
                  elem.style.visibility = 'visible';
                  elem.innerHTML = this.value + " is choosen!";             
                  
                  clientChoosed = true;
                  client_id = this.client_id;
                  client_name = this.name;                 
                  //alert(this.value + " is choosen!");
                    document.getElementById("client_name").value = this.name;
                    document.getElementById("client_company").value = this.company;
                    document.getElementById("client_phone").value = this.phone;
                    document.getElementById("client_address").value = this.address;
                  
                  for(i=0; i<count; i++){
                      var child = document.getElementById('guess_clients');
                      if(child){
                          child.parentNode.removeChild(child); 
                       }     
                  }
                  count=0;
                };
                buttonContainer.appendChild(newButton);
              
            }
            
            }else{
              document.getElementById("livesearch").innerHTML="No Match Result";
            }
          //window.location = "thanks.php";
        })

        // Failed, check status code
        .fail(function( xhr ) {
          alert('getting clietns field!');
        });    
        
      }      
      
      
        function task_create(event){
          
          var temp;     
          // find user name based in user id
          for(i=0; i<name_list.length; i++){
                        
              if(name_list[i].user_id == $('#assign_to option:selected').val()){
                temp = name_list[i].user_name;
                break;
              }
          }
          
          alert( "CLIENT INFO: " + client_id + " & " + client_name );
          
          // check if user selected a client
          if(clientChoosed && client_id && client_name){
            
            
              var formData = {
                'NTclientid' : client_id,
                'NTclientname' : client_name,
                'NTname' : $('input[name=task_name]').val(),
                'NTdescription' : $('input[name=job_description]').val(),
                'NTuserid' : $('#assign_to option:selected').val(),
                'NTusername' : temp,
                'NTdeadline' : $('input[name=deadline]').val(),
                'NTcomment' : $('textarea[name=memo]').val()
              };       

            // Create Ajax request object
            $.ajax({
              url: "/action/task.php",
              type: "POST", 
              data: formData, 
              dataType: "html"
            })

            // Success, shoot stuff
            .done(function( response ) {
                  elem_err.style.visibility = 'hidden';
                  elem.style.visibility = 'visible';
                  elem.innerHTML = "Task Added Successfully!";
              alert("Task Added Successfully!");
            })

            // Failed, also shoot stuff
            .fail(function(xhr) {
              console.log(formData);
                  elem_err.style.visibility = 'visible';
                  elem.style.visibility = 'hidden';
                  elem_err.innerHTML = "create a task failed! bad request!";
            });            
          }else{
            //alert("create a task failed! You must choose a client or create one!");
                  elem_err.style.visibility = 'visible';
                  elem.style.visibility = 'hidden';
                  elem_err.innerHTML = "create a task failed! You must choose a client or create one!";               
          }
          event.preventDefault();
        }
      
    </script>
  </head>

  <body>

    <?php
      include ( $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php' );
      echo navbar( NEW_TASK );
    ?>  
  
    <div id="wrapper">
      <div id="page-wrapper">
        <div id="notice" class="alert alert-success" role="alert"></div>
        <div id="notice_err" class="alert alert-danger" role="alert"></div>
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="row">
            <div class="col-lg-12">
              <h1 class="page-header">
                Create a New Task
              </h1>
              <ol class="breadcrumb">
                <li>
                  <span class="glyphicon glyphicon-dashboard"></span>  <a href="dashboard.php">Dashboard</a>
                </li>
                <li class="active">
                  <span class="glyphicon glyphicon-record"></span> New Task
                </li>
              </ol>
            </div>
          </div>
          <!-- /.row -->
<!-- Modal 1 -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">

            <div id="includedContent"></div>      
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> 
                
          
          
              <!-- ROLANDO'S -->
              <!-- Damn Jason, horrible, horrible identation, the codes spacing is so bad it's so unreadable... --> <!--
              <div class="row">
                <div class="col-md-6">
                  <h4>Rolando's Temp. Task Maker</h4>
                  <div id="rolando-response"></div>
                  <div>
                  <span style="font-weight:bold; font-size:85%">CLIENT:</span> 5411040c993a6 jiashen
                  </div>
                  <form id="rolando-form" role="form" onsubmit="task_create(event)">
                    <input class="form-control" type="hidden" name="clientid" value="5411040c993a6">
                    <input class="form-control" type="text" name="clientname" value="jiashen" disabled>

                    <span style="font-weight:bold; font-size:85%">TASK NAME</span>
                    <input class="form-control" type="text" name="name" placeholder="New Task's name" required>

                    <span style="font-weight:bold; font-size:85%">DESCRIPTION</span>
                    <textarea class="form-control" rows="1" type="text" name="description" style="resize:vertical;" placeholder="Job description" required></textarea>

                    <span style="font-weight:bold; font-size:85%">ASSIGN TO:</span> 540f14437f0f1 rochwu 
                    <input class="form-control" type="hidden" name="userid" value="540f14437f0f1">
                    <input class="form-control" type="text" name="username" value="rochwu" disabled>

                    <span style="font-weight:bold; font-size:85%">DEADLINE</span>
                    <input class="form-control" type="date" name="deadline" required>

                    <span style="font-weight:bold; font-size:85%">COMMENT</span>
                    <textarea class="form-control" rows="3" type="text" name="comment" style="resize:vertical;" placeholder="Leave a comment"></textarea>

                    <button class="btn btn-default btn-block" style="width:200px; margin:10px 0 10px 0" type="submit">Create Task</button>
                  </form>
                </div>  
              </div>
              <!-- END OF ROLANDO's -->
          
          <h4> Chosen Client info: </h4>
          
              <!-- ================================ -->
<!-- Button trigger modal -->
          <div>
            <div class="col-lg-9">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="input-group">
                          <span class="input-group-btn">
                            <button disabled class="btn btn-default" type="button">Client Name</button>
                          </span>
                          <input id='client_name' readonly type="text" class="form-control">
                        </div><!-- /input-group -->
                      </div><!-- /.col-lg-6 -->

                      <div class="col-lg-6">
                        <div class="input-group">
                          <span class="input-group-btn">
                            <button disabled class="btn btn-default" type="button">Company Name</button>
                          </span>
                          <input id='client_company' readonly type="text" class="form-control">
                        </div><!-- /input-group -->
                      </div><!-- /.col-lg-6 -->
                      
                      <div class="col-lg-6">
                        <div class="input-group">
                          <span class="input-group-btn">
                            <button disabled class="btn btn-default" type="button">Client's Phone</button>
                          </span>
                          <input id='client_phone' readonly type="text" class="form-control">
                        </div><!-- /input-group -->
                      </div><!-- /.col-lg-6 -->    
                      
                      <div class="col-lg-6">
                        <div class="input-group">
                          <span class="input-group-btn">
                            <button disabled class="btn btn-default" type="button">Client's Address</button>
                          </span>
                          <input id='client_address' readonly type="text" class="form-control">
                        </div><!-- /input-group -->
                      </div><!-- /.col-lg-6 -->    
                      
                    </div><!-- /.row -->
            </div>           
          </div>
<br><br><br><hr>            
            <div class="form-group">
              
              
               
                <button class="btn btn-primary col-lg-4 col-md-4 col-sm-4 col-xs-4" data-toggle="modal" data-target="#myModal" id="new_client_bt">
                  New Client
                </button>  
                <h3 class="col-lg-1 col-md-1 col-sm-1 col-xs-1">OR</h3>
                <div class=" col-lg-4 col-md-4 col-sm-4 col-xs-4" style="float:left;">
                  <span class="input-group-btn">
                    <button disabled class="btn btn-default" type="button">Enter An Existent Client's Name</button>
                  </span>
                  <input id='search_client' type="text" class="form-control" onkeyup="showResult(this.value)">
                  <div id="livesearch"></div>
                </div><!-- /input-group --><br>               
             </div>
              <br><br><br>
              
          <form role="form" method="post" onsubmit="task_create(event)">              
              
             <div class="form-group">
              <label for="task_name">Task Name&nbsp;</label><span style="color:red" class="glyphicon glyphicon-star"></span>
              <input required name="task_name" type="text" class="form-control" id="task_name" placeholder="Enter Task Name">
            </div> 

            <div class="form-group">
              <label for="job_description">Job Description</label>
              <input name="job_description" type="text" class="form-control wide-window" id="job_description" placeholder="Job Description">
            </div>                   

            <div class="form-group" <?php if($level != 3) { ?> hidden <?php } ?> >
              <label for="assign_to">Assign to&nbsp;</label><span style="color:red" class="glyphicon glyphicon-star"></span>   
              <select name="assign_to" class="form-control" id="assign_to" placeholder="person who will be responsible for the task">

                
              </select>                    
            </div>

            <div class="form-group">
              <label for="deadline">Deadline&nbsp;</label><span style="color:red" class="glyphicon glyphicon-star"></span>
              <input required name="deadline" type="date" class="form-control" id="deadline" >
            </div>

            <div class="form-group">
              <label for="memo">Memo</label>
              <textarea name="memo" rows="4" cols="50" class="form-control" id="memo"></textarea>
            </div>

            <button type="submit" class="btn btn-default">Submit</button>
          </form>

        </div>
      </div>
    </div>

  </body>
  <script>
      var elem = document.getElementById('notice');
      var elem_err = document.getElementById('notice_err');
      elem.style.visibility = 'hidden';
      elem_err.style.visibility = 'hidden';
  </script>

</html>
