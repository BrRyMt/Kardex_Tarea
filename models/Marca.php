<?php
require_once "Conexion.php";

class Marca extends Conexion
{
  private $pdo;

  public function __CONSTRUCT()
  {
    $this->pdo = parent::getConexion();
  }

  public function getAllMR()
  {
    $query = $this->pdo->prepare("SELECT * FROM marcas");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }
}

// $producto = new Marca();
// echo json_encode($producto->getAllMR());