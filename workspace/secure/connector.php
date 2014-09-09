<?php
  
  // IMPORTANT, this file is OUTSIDE document root

  // Include library
  require( 'constants.php' );
  require( 'objects.php' );
  require( 'security.php' );

  // Connects to mysql DB
  class Connector{
    
    private $Connection;
    private $connected = FALSE;
   
    public function __construct(){
      // Using @ to suppress warning
      if( $this->connection = @ mysqli_connect(DB_HOST, DB_USER, DB_PW, DB_DB) ){
        $this->connected = TRUE;
      }
    }
  
    public function __destruct(){
      if( $this->connected ){
        mysqli_close( $this->connection );
      }
    }
    
    // Creates user
    // RETURN: FALSE on failure
    public function make($email, $name, $password, $level){
      
      if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
        return FALSE;
      }
      
      // Assign 0 to $level, for security, not sure how we going to use this yet
      //$level = 0;
      
      // Hash password
      $password_hashed = password_make($password);
      
      if( $stmt = $this->connection->prepare("INSERT INTO users (user_id, email, name, password, level) VALUES (?, ?, ?, ?, ?);") ){
        $stmt->bind_param("ssssi", uniqid(), $email, $name, $password_hashed, $level);
        
        if( $stmt->execute() ){
          $stmt->close();
          return TRUE;
        }else{
          $stmt->close();
          return FALSE;
        }
      }
      
      return FALSE;
    }
    
    // Validates login
    public function login($email, $password){
           
      // Email validation
      if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
        
        // Invalid email
        return NULL;
      }
      
      // Prepared statement
      if( $stmt = $this->connection->prepare("SELECT password, email, name, level  FROM users WHERE email=?") ){
        
        // Bind parameters: s=string, i=int
        $stmt->bind_param("s", $email);
        
        // Executes query
        $stmt->execute();
        
        // Binds query results to these variables
        $stmt->bind_result($stored_password, $stored_email, $name, $level);
        
        // Fetch the results
        $stmt->fetch();
        
        // Close connection
        $stmt->close();

        // Password validation
        // Should probably hash password, instead of just checking it like this
        if( password_check($password, $stored_password) ){
          
          // One more check
          if( $email == $stored_email){
            $User = new User($stored_email, $name, $level);
            return $User;    
          }
        }
      }
      // Failure
      return NULL;
    }
    
    // Task show
    public function task_getby_status($name){
      
      if( $stmt = $this->connection->prepare("SELECT * FROM tasks WHERE assign_to=? AND deadline BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY) ORDER BY deadline ASC") ){
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->bind_result($name, $client, $company, $address, $email, $phone, $description, $assign, $deadline, $memo, $status, $id);
        
        $results = array();
        while( $stmt->fetch() ){
          
          // If array key doesn't exist, create new 
          if( !array_key_exists( $ss, $results) ){
            $results["$ss"] = array();
          }
          
          $Task = new Task($name, $client, $company, $address, $email, $phone, $description, $assign, $deadline, $memo, $status, $id);
          $results["$ss"][] = $Task;
        }
        
        $stmt->close();
        return $results;
      }
      return NULL;
    }
    
    // Task search query
    // This function makes no sense
    public function task_search($method, $keyword){
      
      switch( $method ){
        case SEARCH_TASK:
          $query = "SELECT * FROM tasks WHERE task_name=?";
          break;
        case SEARCH_CLIENT:
          $query = "SELECT * FROM tasks WHERE client_name=?";
          break;
        case SEARCH_DEADLINE:
          $query = "SELECT * FROM tasks WHERE deadline=?";
          break;
        default:
          // Unspecified method called
          return NULL;
      }
      
      if( $stmt = $this->connection->prepare( $query ) ){
        $stmt->bind_param("s", $keyword);
        $stmt->execute();
        $stmt->bind_result($name, $client, $company, $address, $email, $phone, $description, $assign, $deadline, $memo, $status, $id);
        
        $results = array();
        while( $stmt->fetch() ){
          $Task = new Task($name, $client, $company, $address, $email, $phone, $description, $assign, $deadline, $memo, $status, $id);
          $results[] = $Task;
        }
        
        $stmt->close();
        
        return $results;
      }
      
      return NULL;
    }

  } 

?>