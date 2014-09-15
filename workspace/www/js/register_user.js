window.onload=init;
function init()
{
    document.getElementById('register').disabled=true;
}

function checkUserEmail(){
     request = createRequest();
      if (request === null){
          alert("unable to request");
      }
      else{
        var email = document.getElementById('new_email').value;
        var email_re = escape(email);
        var url = "../action/searchUserEmail.php?new_email="+email_re;
        var data = "new_email=" + email_re;
        request.onreadystatechange=searchUser;
        request.open("POST",url,true);
        request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");      
        request.send(data);
      }
}

function searchUser(){
  if (request.readyState==4 && request.status==200) {
      document.getElementById("email_ok").innerHTML=request.responseText;
      var res = request.responseText;
      if(res == '<div style="color:red">*That email is already used</div>' || res==''){
          document.getElementById('register').disabled=true;
        }
      else{
         document.getElementById('register').disabled=false;
      }
    }
} 
