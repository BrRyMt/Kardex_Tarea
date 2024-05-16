<?php

session_start();

require_once "../models/Colaborador.php";

$colaborador = new Colaborador();

if (isset($_GET['operacion'])) {

    switch ($_GET['operacion']) {
        case 'login':

            $login = [
                "permitido"         => false,
                "apepaterno"        => "",
                "apepmaterno"       => "",
                "nombres"           => "",
                "idcolaboradores"   => "",
                "rol"               => "",
                "status"            => ""
            ];

            $row = $colaborador->login(['nomusuario' => $_GET['nomusuario']]);

            if (count($row) == 0) {
                $login["status"] = "No existe el usuario";
            } else {
                $claveEncriptada = $row[0]['passusuario'];
                $passusuario = $_GET['passusuario'];
                if (password_verify($passusuario, $claveEncriptada)) {
                    $login["permitido"] = true;
                    $login["apepaterno"] = $row[0]["apepaterno"];
                    $login["apepmaterno"] = $row[0]["apepmaterno"];
                    $login["nombres"] = $row[0]["nombres"];
                    $login["idcolaboradores"] = $row[0]["idcolaboradores"];
                    $login["rol"] = $row[0]["rol"];
                } else {
                    $login["status"] = "Contraseña Incorrecta";
                }
            }

            $_SESSION['login'] = $login;
            echo json_encode($login);
            break;

        case 'destroy':
            session_unset();
            session_destroy();
            header('Location: http://localhost/kardexadmin/');
            exit();
            break;
    }
}


if (isset($_POST['operacion'])) {
    switch ($_POST['operacion']) {
      case 'add':
        $datos = [
          "idpersona"   => $_POST['idpersona'],
          "idrol"       => $_POST['idrol'],
          "nomusuario" => $_POST['nomusuario'],
          "passusuario" => $_POST['passusuario'],
        ];
        $idusuario = $usuario->add($datos);
        echo json_encode(["idusuario"=>$idusuario]); //Este valor retorna la vista como JSON
        break;
    }
  }