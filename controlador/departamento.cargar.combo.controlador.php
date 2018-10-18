<?php

    

    require_once '../negocio/Departamento.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
	$obj = new Departamento();
        $resultado = $obj->cargarDepartamento();
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
