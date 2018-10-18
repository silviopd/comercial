<?php

    require_once '../negocio/Provincia.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
	$obj = new Provincia();
        $email = $_POST["p_tipoDepartamento"];
        $resultado = $obj->cargarProvincia($email);
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
