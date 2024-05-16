<?php

require_once "../models/Producto.php";

$producto = new Producto();

if (isset($_POST['operacion'])) {
    switch ($_POST['operacion']) {
        case 'addpr':
            $datos = [
                "idmarca"   => $_POST['idmarca'],
                "idtipoproducto"       => $_POST['idtipoproducto'],
                "descripcion" => $_POST['descripcion'],
                "modelo" => $_POST['modelo'],
            ];
            $resultado = $producto->RegistPr($datos);
            echo json_encode($resultado); //Este valor retorna la vista como JSON
            break;
    }
}


if (isset($_GET['operacion'])) {

    switch ($_GET['operacion']) {
        case 'getAll':
            $productos = $producto->getAllPR();
            echo json_encode($productos);
            break;
    }
}