<!DOCTYPE html>
<html>
  <head>
    <title>R</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
  </head>
  
  <body>
    <div class="container">
      
      <h1>Laboratory</h1>
      
      <div id="response-container"></div>
      
      <h4>Add stuff to table</h4>
      <div style="width:50%">
        <form onsubmit="search(event)">
          <div class="input-group">
            <input id="text-box" type="text" class="form-control" name="string" placeholder="Write stuff into table" required>
            <span class="input-group-btn">
              <button class="btn btn-default" type="submit">Send!</button>
            </span>
          </div>
        </form>
      </div>
      
      <h4>Stuff Table</h4>
      <table id="tasks-table" class="table" style="width=100%; table-layout:fixed">
        <thead>
          <tr>
            <th style="width:20%">ID</th>
            <th style="width:80%">Name</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>  

    </div>
    
    <script src="../js/jquery-1.11.0.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script>
      
        function search(event){
          var formData = {
            'Sdata' : $('input[name=string]').val(),
            'Sid' : document.getElementById("#tasks-table").getElementsByTagName("tr").length
          };
          
          $('#text-box').val('');
        
          // Create our ajax requests
          var request = $.ajax({
            url: "action1.php",
            type: "POST", 
            data: formData, 
            dataType: "html"
          })

          // Success, add stuff into table
          .done(function( response ) {
            $('#tasks-table tbody').append( response );
          })
         
          // Failed request 400 Bad Request is likely
          .fail(function(xhr, status, error) {
            $( "#response-container" ).html( xhr.responseText );
          });
          event.preventDefault();
        }
   
    </script>
    
    
  </body>
  
</html>