<?php

session_name("SitemaComercial1");
session_start();

require_once '../negocio/Venta.clase.php';
require_once '../util/funciones/Funciones.clase.php';

//if (!isset($_POST["p_datosFormulario"])) {
//    Funciones::imprimeJSON(500, "Faltan paradmetros", "");
//    exit();
//}

$datosFormulario = $_POST["p_datosFormulario"];
$datosJSONDetalle = $_POST["p_datosJSONDetalle"];

//Convertir todos los datos que llegan concatenados a un array
parse_str($datosFormulario, $datosFormularioArray);


//echo '<pre>';
//print_r($datosFormularioArray);
//echo '</pre>';


try {
    $objVenta = new Venta();
    $objVenta->setCodigo_tipo_comprobante($datosFormularioArray["cbotipocomp"]);
    $objVenta->setNumero_serie($datosFormularioArray["cboserie"]);
    $objVenta->setNumero_documento($datosFormularioArray["txtnrodoc"]);
    $objVenta->setCodigo_cliente($datosFormularioArray["txtcodigocliente"]);
    $objVenta->setFecha_venta($datosFormularioArray["txtfec"]);
    $objVenta->setPorcentaje_igv($datosFormularioArray["txtigv"]);
    $objVenta->setSub_total($datosFormularioArray["txtimportesubtotal"]);
    $objVenta->setIgv($datosFormularioArray["txtimporteigv"]);
    $objVenta->setTotal($datosFormularioArray["txtimporteneto"]);

    $codigoUsuarioSesion = $_SESSION["s_codigo_usuario"];
    $objVenta->setCodigo_usuario($codigoUsuarioSesion);


    //Enviar los datos del detalle en formato JSON
    $objVenta->setDetalleVenta($datosJSONDetalle);

    $resultado = $objVenta->agregar();

    if ($resultado == true) {
        Funciones::imprimeJSON(200, "La venta ha sido registrada correctamente", "");
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}



