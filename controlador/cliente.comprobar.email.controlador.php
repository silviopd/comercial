<?php

    require_once '../negocio/Cliente.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
	$obj = new Cliente();
        $email = $_POST["p_email"];
        $tipo = $_POST["cbotipo"];
        $resultado = $obj->leerEmail($email,$tipo);
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
