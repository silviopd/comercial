<?php

require_once '../negocio/CambioContrasena.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $tipo = $_POST["cbotipo"];
    $email = $_POST["p_email"];

    $ob = new CambioContrasena();
    $nuevaContraseña = $ob->nuevaContra($email, $tipo);
    
    echo '<pre>';
    print_r($nuevaContraseña);
    echo '</pre>';
    
    $resultado=mail($email, "Cambio de Contraseña", $nuevaContraseña);
    if ($resultado==true) {        
        Funciones::imprimeJSON(200, "Exito", "");
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
