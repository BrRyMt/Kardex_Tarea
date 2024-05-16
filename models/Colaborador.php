<?php
require_once "Conexion.php";

class Colaborador extends Conexion
{
  private $pdo;

  public function __CONSTRUCT()
  {
    $this->pdo = parent::getConexion();
  }

  public function getAllPR()
  {
    $query = $this->pdo->prepare("CALL spu_listar_colaboradores()");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }

  public function login($params = [])
  {
    try {
      $query = $this->pdo->prepare("CALL spu_colaboradores_login(?)");
      $query->execute(array($params['nomusuario']));
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function add($params = []): int
{
  $idusuario = null;
  try {
    $query = $this->pdo->prepare("CALL sp_insertarColaborador(?,?,?,?)");
    $query->execute(
      array(
        $params['idpersona'],
        $params['idrol'],
        $params['nomusuario'],
        password_hash($params['passusuario'], PASSWORD_BCRYPT)
      )
    );
    $row = $query->fetch(PDO::FETCH_ASSOC);
    $idusuario = $row['idusuario'];
  } catch (Exception $e) {
    $idusuario = -1;
  }

  return $idusuario;
}
}

// $producto = new Colaborador();
// echo json_encode($producto->getAllPR());