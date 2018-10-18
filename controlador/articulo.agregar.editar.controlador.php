<?php

require_once '../negocio/Articulo.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_datosFormulario"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

$datosFormulario = $_POST["p_datosFormulario"];

//Convertir todos los datos que llegan concatenados a un array
parse_str($datosFormulario, $datosFormularioArray);



////quitar
//print_r($datosFormularioArray);
//exit();

try {
    $objCliente = new Articulo();
    $objCliente->setNombre( $datosFormularioArray["txtnombre"] );
    $objCliente->setPrecioVenta( $datosFormularioArray["txtprecio"] );
    $objCliente->setCodigoCategoria( $datosFormularioArray["cbocategoriamodal"] );
    $objCliente->setCodigoMarca( $datosFormularioArray["cbomarcamodal"] );
    
    if ($datosFormularioArray["txttipooperacion"]=="agregar"){
        $resultado = $objCliente->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }else{
        $objCliente->setCodigoArticulo( $datosFormularioArray["txtcodigo"] );
        
        $resultado = $objCliente->editar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
