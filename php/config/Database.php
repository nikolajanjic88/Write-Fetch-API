<?php

class Database 
{
  private $host = 'localhost';
  private $dbname = 'api_test';
  private $user = 'root';
  private $password = '';
  protected $conn;

  public function connect()
  {
    $dsn = "mysql:host=$this->host;dbname=$this->dbname";
    try
    {
      $this->conn = new PDO($dsn, $this->user, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
      echo 'Error: ' . $e->getMessage();
      return;
    }

    return $this->conn;
  }

}