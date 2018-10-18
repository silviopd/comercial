<?php

    require_once '../negocio/Distrito.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
	$obj = new Distrito();
        $email = $_POST["p_tipoDepartamento"];
        $tipoProvincia = $_POST["p_tipoProvincia"];
        $resultado = $obj->cargarDistrito($email,$tipoProvincia);
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
