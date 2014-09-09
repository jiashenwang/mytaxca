<?php

  class Task{
    
    private $name;
    private $client;
    private $company;
    private $address;
    private $email;
    private $phone;
    private $description;
    private $assigned_to;
    private $deadline;
    private $memo;
    
    public function __construct($n, $c, $co, $a, $e, $p, $d, $at, $dl, $m, $s, $i){
      $this->name = $n;
      $this->client = $c;
      $this->company = $co;
      $this->address = $a;
      $this->email = $e;
      $this->phone = $p;
      $this->description = $d;
      $this->assigned_to = $at;
      $this->deadline = $dl;
      $this->memo = $m;
      $this->status = $s;
      $this->id = $i;
    }
    
    public function getName(){
      return $this->name;
    }
    
    public function getClient(){
      return $this->client;
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
    
    public function getDescription(){
      return $this->description;
    }
    
    public function getAssignedTo(){
      return $this->assigned_to;
    }
    
    public function getDeadline(){
      return $this->deadline;
    }
    
    public function getMemo(){
      return $this->memo;
    }
    
    public function getStatus(){
      return $this->status;
    }
    
    public function getId(){
      return $this->id;
    }
  }

  class User{
    
    private $email;
    private $name;
    private $level;
  
    public function __construct($e, $n, $l){
      $this->email = $e;
      $this->name = $n;
      $this->level = $l;
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
  }  


?>