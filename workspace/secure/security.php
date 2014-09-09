<?php

  // Hashes password
  function password_make($password){
    
    // Target time
    $target_time = 0.2;
    $cost = 9;
    
    // Finds best cost for hashing, starts at 10
    do {
        $cost++;
        $start = microtime(true);
      
        // Using CRYPT BLOWFISH + DEV/URANDOM hardware salt
        $result = password_hash( $password, PASSWORD_BCRYPT, ['cost' => $cost] );
        $end = microtime(true);
    } while ( ($end - $start) < $target_time );
    
    return $result;
  }

  // Validates password
  function password_check($password, $stored_password){
    return password_verify($password, $stored_password);
  }

  // Validate POST/GET HTTP method array
  function method_validate($method, $expected){
    
    // Validate array size
    if( sizeof($method) != sizeof($expected) ){
      return FALSE;
    }
    
    // Converts values to keys
    $expected = array_flip( $expected );
    
    // Validate keys, ensure they're equal
    // The size of the difference is not 0
    if( sizeof( array_diff_key($expected, $method) ) ){
      return FALSE;
    }
    
    return TRUE;
  }

?>