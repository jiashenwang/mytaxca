function createRequest() {
  var request;
  try {
         request = new XMLHttpRequest();  // request for IE, chrome, firefox, etc
  } catch (tryMS) {
        try {
              request = new ActiveXObject("Msxml2.XMLHTTP");  // for IE
        } catch (otherMS) {
                try {
                        request = new ActiveXObject("Microsoft.XMLHTTP");    // for IE
                 } catch (failed) {  // if request is faile, then return null
                        request = null;
                 }
        }
  }
  
  return request;
}