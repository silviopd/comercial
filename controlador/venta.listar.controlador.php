<?php

require_once '../negocio/Venta.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {

    if (!isset($_POST["tipo"])) {
        Funciones::imprimeJSON(500, "Faltan parametros", "");
        exit;
    }

    $fechaInicio = $_POST["fechaInicio"];
    $fechaFinal = $_POST["fechaFinal"];
    $tipo = $_POST["tipo"];

    $objVenta = new Venta();
    $resultado = $objVenta->listar($fechaInicio, $fechaFinal, $tipo);

    Funciones::imprimeJSON(200, "", $resultado);
} catch (Exception $exc) {
    //Funciones::mensaje($exc->getMessage(), "e");
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

