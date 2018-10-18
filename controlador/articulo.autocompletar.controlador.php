<?php

require_once '../negocio/Articulo.clase.php';
require_once '../util/funciones/Funciones.clase.php';


$obj = new Articulo();

$valorBusqueda = $_GET["term"];

$resultado = $obj->cargarDatosArticulo($valorBusqueda);

//echo '<pre>';
//print_r($resultado);
//echo '</pre>';

$datos = array();

for ($i=0;$i<count($resultado);$i++){
    $registro = array(
        'label' => $resultado[$i]["nombre"],
        'value' => array(
            'codigo' => $resultado[$i]["codigo_articulo"],
            'nombre' => $resultado[$i]["nombre"],
            'stock' => $resultado[$i]["stock"],
            'precio' => $resultado[$i]["precio_venta"]
        )
    );
    $datos[$i] = $registro;
}

//echo '<pre>';
//print_r($datos);
//echo '</pre>';

echo json_encode($datos);