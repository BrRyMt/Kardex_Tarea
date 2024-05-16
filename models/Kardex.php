<?php
require_once "Conexion.php";

class Kardex extends Conexion
{
    private $pdo;

    public function __CONSTRUCT()
    {
        $this->pdo = parent::getConexion();
    }

    public function getAllkx()
    {
        $query = $this->pdo->prepare("select * from vs_kardex");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function RegistMv($params = [])
    {
        $query = $this->pdo->prepare("CALL registrarMovimiento(?, ?, ?, ?)");
        $query->execute([
            $params['idcolaborador'],
            $params['idproducto'],
            $params['tipomovimiento'],
            $params['cantidad']
        ]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filterMv($params = [])
    {
        try {
            $query = $this->pdo->prepare("CALL sp_filtrar_kardex_por_producto(?,?);");
            $query->execute(
                array(
                    $params['producto'],
                    $params['limit_n']
                )
            );
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
