<?php

require_once '../negocio/CambioContrasena.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
	$obj = new CambioContrasena();
        $contra = $_POST["p_contra"];
        $resultado = $obj->validarcontrasena($contra);
        
        echo '<pre>';
        print_r($resultado);
        echo '</pre>';
        
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }