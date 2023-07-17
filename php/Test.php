<?php

class Test
{
  public $id;
  public $name;
  public $country;
  public $age; 

  private $table = 'test';
  private $conn;

  public function __construct($db){
    $this->conn = $db;
}

  public function read()
  {
    $sql = "SELECT * FROM $this->table ORDER BY created_at DESC";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt;
  }

  public function edit()
  {
    $sql = "SELECT * FROM $this->table WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $this->id=htmlspecialchars(strip_tags($this->id));
    $stmt->bindValue(':id', $this->id);

    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->name = $row['name'] ?? null;
    $this->country = $row['country'] ?? null;
    $this->age = $row['age'] ?? null;
 
  }

  public function insert()
  {
    $sql = "INSERT INTO $this->table (name, country, age) VALUES (:name, :country, :age)";
    $stmt = $this->conn->prepare($sql);

    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->country=htmlspecialchars(strip_tags($this->country));
    $this->age=htmlspecialchars(strip_tags($this->age));
   
    $stmt->bindValue(':name', $this->name);
    $stmt->bindValue(':country', $this->country);
    $stmt->bindValue(':age', $this->age);
    
    if($stmt->execute()){
      return true;
    }

    return false;
  }

  public function update()
  {
    $sql = "UPDATE $this->table SET name = :name, country = :country, age = :age WHERE id = :id";
    $stmt = $this->conn->prepare($sql);

    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->country=htmlspecialchars(strip_tags($this->country));
    $this->age=htmlspecialchars(strip_tags($this->age));
   
    $stmt->bindValue(':name', $this->name);
    $stmt->bindValue(':country', $this->country);
    $stmt->bindValue(':age', $this->age);
    $stmt->bindValue(':id', $this->id);
    
    if($stmt->execute()){
      return true;
    }
    return false;
  }

  public function delete()
  {
    $query = "DELETE FROM $this->table WHERE id = :id";
    $stmt = $this->conn->prepare($query);

    $this->id=htmlspecialchars(strip_tags($this->id));
  
    $stmt->bindParam(':id', $this->id);

    if($stmt->execute()){
        return true;
    }
    return false;
  }
}