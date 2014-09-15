<?php
  session_start();

  // Include validators
  require ( '../../secure/connector.php' );

  $q=$_POST["q"];

  if( $connection = new Connector() ){
      $array = array();
     if( $clients = $connection->client_getAll() ){
           foreach($clients as $client) {
             similar_text($client->getName(), $q, $percent);
             if($percent>=80){
               $array[] = array('client_id'=>$client->getId(),
                            'client_type'=>$client->getType(),
                            'client_name'=>$client->getName(),
                            'client_company'=>$client->getCompany(),
                            'client_address'=>$client->getAddress(),
                            'client_email'=>$client->getEmail(),
                            'client_phone'=>$client->getPhone()); 
             }            
           } 
       if(isset($array)){
          print_r (json_encode($array, true));
       }else{
         echo('Nothing to display.');
       }
         header('HTTP/1.1 200 OK');
          exit;
      }
   }
   header('HTTP/1.1 403 Forbidden');

    
?>
