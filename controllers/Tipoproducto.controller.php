<?php

require_once "../models/Tipoproduct.php";

$tipoproduc = new Tipoproduct();



if (isset($_GET['operacion'])) {

    switch ($_GET['operacion']) {
        case 'getAll':
            $tps = $tipoproduc->getAllTP();
            echo json_encode($tps);
            break;
    }
}
