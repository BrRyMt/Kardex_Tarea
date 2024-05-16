<?php

require_once "../models/Marca.php";

$marca = new Marca();


if (isset($_GET['operacion'])) {

    switch ($_GET['operacion']) {
        case 'getAll':
            $marcas = $marca->getAllMR();
            echo json_encode($marcas);
            break;
    }
}
