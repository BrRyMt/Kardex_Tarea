<?php

require_once "../models/Persona.php";

$persona = new Persona();

if (isset($_POST['operacion'])) {
    switch ($_POST['operacion']) {
      case 'add':
        $datos = [
          "p_apepaterno"     => $_POST['p_apepaterno'],
          "p_apepmaterno"       => $_POST['p_apepmaterno'],
          "p_nombres"       => $_POST['p_nombres'],
          "p_nrodocumento"  => $_POST['p_nrodocumento'],
          "p_telprincipal"      => $_POST['p_telprincipal'],
          "p_telsecundario"      => $_POST['p_telsecundario'],
        ];
        $idobtenido = $persona->add($datos); //Positivo - Negativo 
        echo  json_encode(["idpersona" => $idobtenido]); //Retornados a la vista como un json
        break;
    }
  }
  