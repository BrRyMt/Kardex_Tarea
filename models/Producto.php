<?php
require_once "Conexion.php";

class Producto extends Conexion
{
  private $pdo;

  public function __CONSTRUCT()
  {
    $this->pdo = parent::getConexion();
  }

  public function getAllPR()
  {
    $query = $this->pdo->prepare("CALL spu_listar_productos()");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }

  public function RegistPr($params = [])
  {
    $query = $this->pdo->prepare("CALL spu_registrar_productos(?,?,?,?)");
    $query->execute(
      [
        $params['idmarca'],
        $params['idtipoproducto'],
        $params['descripcion'],
        $params['modelo']
      ]
    );
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }
}



// $producto = new Producto();
// echo json_encode($producto->getAllPR());

// NO OLVIDAR MODIFICAR UNO PARA QUE SEA BY TIPO DE PRODUCTO TIPO REFRIGERADOR Y ESO, ES NECESARIO!!!!