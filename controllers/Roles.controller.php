<?php

require_once "../models/Roles.php";

$roles = new Roles();

if (isset($_GET['operacion'])) {

    switch ($_GET['operacion']) {
        case 'getAll':
            $tps = $roles->getAllRL();
            echo json_encode($tps);
            break;
    }
}
