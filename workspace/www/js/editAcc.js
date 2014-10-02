window.onload=dispEmail;
function dispEmail(){
   document.getElementById('register').disabled=true;
   request = createRequest();
   if (request === null){
      alert("unable to request");
   }
  else{
        var url = "../action/user_getInfo.php";
        request.open("GET",url,true);    
        request.send(null);
        request.onreadystatechange=editAcc;
  }
}
function editAcc(){

      if (request.readyState==4 && request.status==200){   
           var jsonObj = JSON.parse(request.responseText);
          document.getElementById("new_email").value=jsonObj.email;
          document.getElementById("new_name").value=jsonObj.name;
          document.getElementById("new_name").select();
      }
}

function matchPass(){
      document.getElementById('register').disabled=true;
  
      if(passValid() === true){
          var new_pass = document.getElementById('new_ps').value;
          var conf_pass = document.getElementById('confirm_pass').value;
          if(conf_pass ===""){
            document.getElementById('conf_error').innerHTML='';
            document.getElementById('conf_ok').innerHTML='';
          }
          else if(new_pass == conf_pass){
               document.getElementById('conf_error').innerHTML='';
               document.getElementById('conf_ok').innerHTML="password ok";
               document.getElementById('register').disabled=false;
          }
          else {
            document.getElementById('conf_ok').innerHTML='';
            document.getElementById('conf_error').innerHTML="Please match the password as above";
          }
      }else{
          document.getElementById('register').disabled=true;
      }         
}

function passValid(){
      var new_pass = document.getElementById('new_ps').value;
      // pass length from 4 to 20
      // contain at least one numeric digic, one upper and one lower letter
      var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,20}$/;
      if(new_pass ===""){
            document.getElementById('pass_error').innerHTML='';
            document.getElementById('pass_ok').innerHTML='';
            return false;
      }
      else if(new_pass.match(passw)){
          document.getElementById('pass_error').innerHTML='';
          document.getElementById('pass_ok').innerHTML="Password ok";
          return true;
      }else{
          document.getElementById('pass_ok').innerHTML='';
          document.getElementById('pass_error').innerHTML ="Password must contain at least 4 characters, including UPPER/lowercase and numbers.";
          return false;
      }
}

/*
  // Rolando to Bryan jquery ajax lesson #123189
  function chkOldPass(event){
    
    // Using JS array. Array indexes with prefix "EA" for Edit Account
    var formData = {
      'EAemail' : $('input[name=new_email]').val(),
      'EAname' : $('input[name=new_name').val(),
      'EAold_password' : $('input[name=old_pass').val(),
      'EAnew_password' : $('input[name=new_ps').val()
    }
    
    // Creates AJAX request object
    $.ajax({
      url: "/action/user_update.php",
      type: "POST", 
      data: formData, 
      dataType: "html"
    })
    .done( function( response ){ // This can also be .done( function(){ // Content here } )
      // Whatever you echo in updateUser.php will be passed as a huge string, that string is "response"
      // Example: You can use "alert( response );" if you want the alert to display something from updateUser.php
      alert( response );
      
      // Force a page refresh to update username on the navbar
      // I used AJAX to redraw the navbar but it was a bad idea since that has no sanitation
      location.reload();
    })
    .fail( function( xhr ){
      // Whatever you echo in updateUser.php will be passed as a huge string, that string is "xhr.responseText"
      
      // I'm on purposely not saying what is the wrong input so hackers can't guess whether it's a bad email, password or both, etc.
      alert( "FAILURE" );
    });
    
    // clear field
    document.getElementById('old_pass').value='';
    document.getElementById('new_ps').value='';
    document.getElementById('confirm_pass').value='';
    document.getElementById('pass_ok').innerHTML='';
    document.getElementById('conf_ok').innerHTML='';
    
    //event.preventDefault();  
  }
*/

function chkOldPass(){
       var email = escape(document.getElementById('new_email').value);
       var pass = escape(document.getElementById('old_pass').value);
       var name = escape(document.getElementById('new_name').value);
       var new_pass = escape(document.getElementById('new_ps').value);

       // confirm the old pass
         request = createRequest();
         if (request === null){
            alert("unable to request");
         }
        else{
            var url = "../action/user_update.php";
            var data = "EAemail="+email+"&EAold_password="+pass+"&EAname="+name+"&EAnew_password="+new_pass;
            
            request.open("POST",url,false);   
            request.onreadystatechange=respCheckPass;
            request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
            request.send(data);          
        }

      // clear field
      document.getElementById('old_pass').value='';
      document.getElementById('new_ps').value='';
      document.getElementById('confirm_pass').value='';
      document.getElementById('pass_ok').innerHTML='';
      document.getElementById('conf_ok').innerHTML='';
      return false;
}


function respCheckPass(){
      if (request.readyState==4 && request.status==200) {
          if( request.responseText == "1"){
              document.getElementById('user_error').style.display='none';
              document.getElementById('user_success').style.display='block';
              document.getElementById('user_success').innerHTML="UPDATED !";
              document.getElementById('register').disabled=true;
          }
          else if( request.responseText == "2"){
            document.getElementById('user_success').style.display='none';
            document.getElementById('user_error').style.display='block';
            document.getElementById('user_error').innerHTML="PLEASE CHECK YOUR OLD PASSWORD";
            document.getElementById('register').disabled=true;
            
          }
      }
}