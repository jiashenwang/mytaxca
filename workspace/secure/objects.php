<?php

  // $id, $name, $client_id, $client_name, $deadline, $user_id, $description, $memo, $status, $pinned );

  class Task{
    
    // Task identifiers
    private $id;
    private $name;
    
    // Task client info
    private $client_id;
    private $client_name;
    
    // Task handling user info
    private $user_id;
    private $user_name;
    
    private $deadline;
    private $description;
    private $comment;
    private $status;
    private $pinned;
    
    public function __construct($i, $n, $ci, $cn, $ui, $un, $dl, $jd, $c, $st, $p){
      $this->id = $i;                   
      $this->name = $n;
      $this->client_id = $ci;                                   
      $this->client_name = $cn;
      $this->user_id = $ui;     
      $this->user_name = $un;
      $this->deadline = $dl;           
      $this->description = $jd;
      $this->comment = $c;
      $this->status = $st;
      $this->pinned = $p;
    }
    
    public function getId(){
      return $this->id;
    }
    
    public function getName(){
      return $this->name;
    }
    
    public function getClientId(){
      return $this->client_id;
    }
    
    public function getClientName(){
      return $this->client_name;
    }
    
    public function getUserId(){
      return $this->user_id;
    }
    
    public function getUserName(){
      return $this->user_name;
    }
    
    public function getDeadline(){
      return $this->deadline;
    }
    
    public function getDescription(){
      return $this->description;
    }
    
    public function getComment(){
      return $this->comment;
    }
    
    public function getStatus(){
      return $this->status;
    }
    
    public function isPinned(){
      return $this->pinned;
    }
    
  }

  class User{
    
    private $id;
    private $email;
    private $name;
    private $level;
    private $phone;
  
    public function __construct($i, $e, $n, $l, $p){
      $this->id = $i;
      $this->email = $e;
      $this->name = $n;
      $this->level = $l;
      $this->phone = $p;
    } 
      
    
    public function getId(){
      return $this->id;
    }
    public function getEmail(){
      return $this->email;
    }
    
    public function getName(){
      return $this->name;
    }
    
    public function getLevel(){
      return $this->level;
    }
    
    public function getPhone(){
      return $this->phone;
    }
  }  

  class Client{
    
    private $id;
    private $type;
    private $name;
    private $company;
    private $address;
    private $email;
    private $phone;
  
    public function __construct($ci, $ct, $cn, $cc, $a, $ce, $cp){
      $this->id = $ci;
      $this->type = $ct;
      $this->name = $cn;
      $this->company = $cc;
      $this->address = $a;
      $this->email = $ce;
      $this->phone = $cp;
    } 
    
    public function getId(){
      return $this->id;
    }
    public function getType(){
      return $this->type;
    }
    
    public function getName(){
      return $this->name;
    }
    
    public function getCompany(){
      return $this->company;
    }
    
    public function getAddress(){
      return $this->address;
    }
    public function getEmail(){
      return $this->email;
    }
    public function getPhone(){
      return $this->phone;
    }    
  }  


?>