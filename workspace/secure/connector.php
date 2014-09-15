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
    
    // get all clients' info
    // return an object array
    public function client_getAll(){
      $array = array();
      if( $stmt = $this->connection->prepare("SELECT * FROM clients;") ){
        $stmt->execute();
        $stmt->bind_result($id, $type, $name, $company, $address, $email, $phone);
        
        $results = array();
        while( $stmt->fetch() ){
          $Client = new Client($id, $type, $name, $company, $address, $email, $phone);
          $results[] = $Client;
        }           
        
          $stmt->close();
          return $results;
      }
      return null;
    }
    
    // get all users' info
    // return an object array

    public function user_getAll(){
      $array = array();
      if( $stmt = $this->connection->prepare("SELECT user_id, email, name, level, phone FROM users;") ){
        $stmt->execute();
        $stmt->bind_result($user_id, $email, $name, $level, $phone);
        
        $results = array();
        while( $stmt->fetch() ){
          $User = new User($user_id, $email, $name, $level, $phone);
          $results[] = $User;
        }           
        
          $stmt->close();
          return $results;
      }
      return null;
      
    }
    
    // Creates client
    // Return: FALSE on failure
    public function client_create($client_type, $client_name, $client_company, $address, $client_email, $client_phone ){
      
      if( $stmt = $this->connection->prepare("INSERT INTO clients (client_id, client_type, client_name, client_company, address, client_email, client_phone) VALUES (?, ?, ?, ?, ?, ?, ?);") ){
        $client_id = uniqid('C');
        
        $stmt->bind_param("sisssss", $client_id, $client_type ,$client_name , $client_company, $address, $client_email, $client_phone);
        
        if( $stmt->execute() ){
          $stmt->close();

          return $client_id;
        }else{
          $stmt->close();
          return NULL;
        }        
      }
      
      return NULL;
    }
    
    
        
    // Creates user
    // RETURN: FALSE on failure
    public function make($email, $name, $password, $level){
      
      if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
        return FALSE;
      }
      
      // Hash password
      $password_hashed = password_make($password);
      
      if( $stmt = $this->connection->prepare("INSERT INTO users (user_id, email, name, password, level) VALUES (?, ?, ?, ?, ?);") ){
        $user_id = uniqid('U');
        
        $stmt->bind_param("ssssi", $user_id, $email, $name, $password_hashed, $level);
        
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
      if( $stmt = $this->connection->prepare("SELECT user_id, password, email, name, level, phone  FROM users WHERE email=?") ){
        
        // Bind parameters: s=string, i=int
        $stmt->bind_param("s", $email);
        
        // Executes query
        $stmt->execute();
        
        // Binds query results to these variables
        $stmt->bind_result($user_id, $stored_password, $stored_email, $name, $level, $phone);
        
        // Fetch the results
        $stmt->fetch();
        
        // Close connection
        $stmt->close();

        // Password validation
        // Should probably hash password, instead of just checking it like this
        if( password_check($password, $stored_password) ){
          
          // One more check
          if( $email == $stored_email){
            $User = new User($user_id, $stored_email, $name, $level, $phone);
            return $User;    
          }
        }
      }
      // Failure
      return NULL;
    }
    
    // Task create
    // RETURNS: FALSE on failure
    public function task_create( $client_id, $client_name, $name, $description, $user_id, $user_name, $deadline, $comment ){
      
      if( $stmt = $this->connection->prepare("INSERT INTO tasks VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)") ){
        
        $id = uniqid('T');
        $status = "0";
        $pinned = "0";
        
        $stmt->bind_param( "sssssssssii", $id, $name, $client_id, $client_name, $user_id, $user_name, $deadline, $description, $comment, $status, $pinned );
        if( $stmt->execute() ){
          $stmt->close();
          return TRUE;
        }
        
        $stmt->close();
      }
      
      return FALSE;
    }
    
    public function task_create_e( $client_id, $client_name, $name, $description, $deadline, $comment ){
      
      if( $stmt = $this->connection->prepare("INSERT INTO tasks VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)") ){
        
        $id = uniqid('T');
        $status = "0";
        $pinned = "0";
        
        $stmt->bind_param( "sssssssii", $id, $name, $client_id, $client_name, $deadline, $description, $comment, $status, $pinned );
        if( $stmt->execute() ){
          $stmt->close();
          return TRUE;
        }
        
        $stmt->close();
      }
      
      return FALSE;
    }    
    
    // Task update
    public function task_update( $task_id, $pinned, $status, $description, $user, $user_id, $deadline, $comment ){
      
      if( $stmt = $this->connection->prepare("UPDATE tasks SET pinned=?, status=?, job_description=?, user_name=?, user_id=?, deadline=?, comment=? WHERE task_id=?") ){
        $stmt->bind_param("iissssss", $pinned, $status, $description, $user, $user_id, $deadline, $comment, $task_id);
        if( $stmt->execute() ){
          $stmt->close();
          return TRUE;
        }
        $stmt->close();
      }
      return FALSE;
    }
        
    // Task get by id
    public function task_getby_id( $task_id ){
      
      if( $stmt = $this->connection->prepare("SELECT * FROM tasks WHERE task_id=?") ){
        $stmt->bind_param("s", $task_id);
        $stmt->execute();
        $stmt->bind_result( $id, $name, $client_id, $client_name, $user_id, $user_name, $deadline, $description, $comment, $status, $pinned );
        $stmt->fetch();
        $stmt->close();
        
        $Task = new Task( $id, $name, $client_id, $client_name, $user_id, $user_name, $deadline, $description, $comment, $status, $pinned );
        return $Task;
      }
      return NULL;
    }
    
    // Task show
    public function task_getby_status( $caller_id, $caller_level ){
      
      // Show all tasks to OWNER level
      if( $caller_level == OWNER ){
        $query = "SELECT * FROM tasks WHERE deadline BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY) ORDER BY deadline ASC";
      }else{
        $query = "SELECT * FROM tasks WHERE user_id=? AND deadline BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY) ORDER BY deadline ASC";
      }
            
      if( $stmt = $this->connection->prepare( $query ) ){
        
        if( $caller_level != OWNER ){
          $stmt->bind_param("s", $caller_id);
        }

        $stmt->execute();
        $stmt->bind_result( $id, $name, $client_id, $client_name, $user_id, $user_name, $deadline, $description, $comment, $status, $pinned );
        
        $results = array();
        while( $stmt->fetch() ){
          
          // If array key doesn't exist, create new 
          if( !array_key_exists( $status, $results) ){
            $results["$status"] = array();
          }
          
          $Task = new Task( $id, $name, $client_id, $client_name, $user_id, $user_name, $deadline, $description, $comment, $status, $pinned );
          $results["$status"][] = $Task;
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