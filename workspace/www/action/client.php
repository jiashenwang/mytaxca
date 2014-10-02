<?php
  session_start();

  // Include validators
  require ( '../../secure/connector.php' );

  // Ensure HTTP METHODS are set and unset respectively
  if( isset($_POST) && empty($_GET) ){
    
    // Validates POST array
    if( $result = method_validate( $_POST, ['entered_new_client_name', 'entered_new_client_type', 'entered_new_client_company', 'entered_new_client_address', 'entered_new_client_email', 'entered_new_client_phone'] ) ){
      
      $name = $_POST['entered_new_client_name'];
      $type = $_POST['entered_new_client_type'];
      $company = $_POST['entered_new_client_company'];
      $address = $_POST['entered_new_client_address'];
      $email = $_POST['entered_new_client_email'];
      $phone = $_POST['entered_new_client_phone'];
    
      action( $name, $type, $company, $address, $email, $phone );

    }   
  }
  

  // Restricted access failure
  header('HTTP/1.1 404 Not Found');


  // Action, queries credentials
  function action($name, $type, $company, $address, $email, $phone){
      global $Client_ID;
      if( $connection = new Connector() ){
        if( $Client_ID = $connection->client_create( $type, $name, $company, $address, $email, $phone ) ){
                   
          header('HTTP/1.1 200 OK');
          echo json_encode($Client_ID);
          
          exit;
        }
      }
      header('HTTP/1.1 403 Forbidden');
    failure();
  }

  // Validation failure
  function failure(){
    echo <<< HTML
      <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>Warning!</strong> Invalid customer email address or name
      </div>
HTML;
    exit;
  }
    
?>
