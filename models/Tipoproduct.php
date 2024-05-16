<?php
require_once "Conexion.php";

class Tipoproduct extends Conexion
{
  private $pdo;

  public function __CONSTRUCT()
  {
    $this->pdo = parent::getConexion();
  }

  public function getAllTP()
  {
    $query = $this->pdo->prepare("SELECT * FROM tipoproducto");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }
}

// $producto = new Tipoproduct();
// echo json_encode($producto->getAllTP());