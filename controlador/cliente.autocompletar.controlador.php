<?php

require_once '../negocio/Cliente.clase.php';
require_once '../util/funciones/Funciones.clase.php';


$obj = new Cliente();

$valorBusqueda = $_GET["term"];

$resultado = $obj->cargarDatosCliente($valorBusqueda);

//echo '<pre>';
//print_r($resultado);
//echo '</pre>';

$datos = array();

for ($i = 0; $i < count($resultado); $i++) {
    $registro = array(
        'label' => $resultado[$i]["nombre_completo"],
        'value' => array(
            'codigo' => $resultado[$i]["codigo_cliente"],
            'nombre' => $resultado[$i]["nombre_completo"],
            'direccion' => $resultado[$i]["direccion"],
            'telefono' => 'Fijo: ' . $resultado[$i]["telefono_fijo"] . '    Mov1: ' . $resultado[$i]["movil1"] . '     Mov2: ' . $resultado[$i]["movil2"]
        )
    );
    $datos[$i] = $registro;
}

//echo '<pre>';
//print_r($datos);
//echo '</pre>';

echo json_encode($datos);
