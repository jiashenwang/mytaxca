window.onload=init;
function init()
{ document.getElementById('register').disabled=true; }

// checking email if duplicated or not
function checkUserEmail(){
     request = createRequest();
      if (request === null){
          alert("unable to request");
      }
      else{
        var email = document.getElementById('new_email').value;
        var email_re = escape(email);
        var url = "../action/search_UserEmail.php?new_email="+email_re;
        var data = "new_email=" + email_re;
        
        request.open("POST",url,true);
        request.onreadystatechange=searchUser;
        request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");      
        request.send(data);
      }
}

function searchUser(){
  if (request.readyState==4 && request.status==200) {
      document.getElementById("email_ok").innerHTML=request.responseText;
      var res = request.responseText;
      if(res == '<div style="color:red">*That email is already used</div>' || res==='' || res=='<div style="color:red">Not a valid email address</div>'){
          document.getElementById('register').disabled=true;
        }
      else{
         document.getElementById('register').disabled=false;
      }
    }
} 

function addUser() {
        // creating request
        request = createRequest();
        if (request === null){
          alert("unable to request");
        } 
        else{
            var email = escape(document.getElementById('new_email').value);
            var name =  escape(document.getElementById('new_name').value);
            var pass =  escape(document.getElementById('initial_pass').value);
            var level =  escape(document.getElementById('new_level').value);
            
            // validating username and email address
            var pattern = /^[a-z]{2,25}$/i;
            var text = document.getElementById('new_name');
            var pattern2 = /^[a-z0-9._-]+@[a-z]+.[a-z.]{2,5}$/i;
            var text2 = document.getElementById('new_email');
            var pattern3 = /^[a-z0-9._-]{2,25}$/i;
            var text3 = document.getElementById('initial_pass');
            if(!pattern.test(text.value) ){
                document.getElementById('user_error').style.display='block';          
                document.getElementById('name_error').innerHTML="*Username should not contain numbers, spaces, or special characters";
                text.select();                
            }
            else if(!pattern3.test(text3.value)){
                document.getElementById('user_error').style.display='block';
                document.getElementById('pass_error').innerHTML="*Password should be \nat least 4 letters \nconsist of number and characters";
                text3.select();           
            }
            else {
              document.getElementById('user_error').style.display='none';
              // sending data to addUser
              var data = "new_email="+email+"&new_name="+name+"&initial_pass="+pass+
                          "&new_level="+level;
              var url = "../action/user_register.php";

              request.open("POST",url, false);
              request.onreadystatechange=addProcess;
              request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");      
              request.send(data);
              
            }
      }    
}
function addProcess(){
      //alert(request.readyState+" "+request.status);
     if (request.readyState==4 && request.status==200) {
          document.getElementById('user_success').style.display='block';
          document.getElementById('user_success').innerHTML=request.responseText;
          document.getElementById('new_email').value='';
          document.getElementById('new_name').value='';
          document.getElementById('initial_pass').value='';
          document.getElementById('pass_error').innerHTML='';
          document.getElementById('name_error').innerHTML='';
     }
}

