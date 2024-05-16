<?php
require_once "Conexion.php";

class Roles extends Conexion
{
  private $pdo;

  public function __CONSTRUCT()
  {
    $this->pdo = parent::getConexion();
  }

  public function getAllRL()
  {
    $query = $this->pdo->prepare("SELECT * FROM roles;");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }
}