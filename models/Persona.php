<?php
require_once "Conexion.php";

class Persona extends Conexion
{
  private $pdo;

  public function __CONSTRUCT()
  {
    $this->pdo = parent::getConexion();
  }

  public function add($params = []): int
  {
    $idgenerado = null;
    try {
      $query = $this->pdo->prepare("CALL sp_registrar_persona(?,?,?,?,?,?)");
      $query->execute(
        array(
          $params['p_apepaterno'],
          $params['p_apepmaterno'],
          $params['p_nombres'],
          $params['p_nrodocumento'],
          $params['p_telprincipal'],
          $params['p_telsecundario']
        )
      );
      $row = $query->fetch(PDO::FETCH_ASSOC);
      $idgenerado = $row['idpersona'];
    } catch (Exception $e) {
      $idgenerado = -1;
    }

    return $idgenerado;
  }

}