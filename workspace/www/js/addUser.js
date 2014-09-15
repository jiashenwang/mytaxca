function addUser(){
   request = createRequest();
   if (request === null){
      alert("unable to request");
   }
   else{
      var url = "../addUser.php";
      var data ="new_email=" +
           escape(document.getElementById('new_email').value) + "&new_name=" +
           escape(document.getElementById('new_name').value) + "&initial_pass=" +
           escape(document.getElementById('initial_pass').value) + "&new_level=" +
           escape(document.getElementById('new_level').value);
       
      request.onreadystatechange = addProcess;
      request.open("POST", url, true);
      request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
      request.send(data);
   }
}

function addProcess(){
   if (request.readyState==4 && request.status==200){
      document.getElementById("submit_result").innerHTML=request.responseText;
   }
  
}