<?php

require_once '../negocio/Cliente.clase.php';
require_once '../util/funciones/Funciones.clase.php';

//if (! isset($_POST["p_datosFormulario"]) ){
//    Funciones::imprimeJSON(500, "Faltan parametros", "");
//    exit();
//}

$datosFormulario = $_POST["p_datosFormulario"];

//Convertir todos los datos que llegan concatenados a un array
parse_str($datosFormulario, $datosFormularioArray);



////quitar
//print_r($datosFormularioArray);
//exit();

try {
    $objCliente = new Cliente();
    $objCliente->setApellido_paterno( $datosFormularioArray["txtapellidopaterno"] );
    $objCliente->setApellido_materno( $datosFormularioArray["txtapellidomaterno"] );
    $objCliente->setNombres( $datosFormularioArray["txtnombre"] );
    $objCliente->setNro_documento_identidad( $datosFormularioArray["txtnrodocumento"] );
    $objCliente->setDireccion( $datosFormularioArray["txtdireccion"] );
    $objCliente->setTelefono_fijo( $datosFormularioArray["txttelefonofijo"] );
    $objCliente->setTelefono_movil1( $datosFormularioArray["txttelefonomovil1"] );
    $objCliente->setTelefono_movil2( $datosFormularioArray["txttelefonomovil2"] );
    $objCliente->setEmail( $datosFormularioArray["txtemail"] );
    $objCliente->setCodigo_departamento( $datosFormularioArray["cbodepartamento"] );
    $objCliente->setCodigo_provincia( $datosFormularioArray["cboprovincia"] );
    $objCliente->setCodigo_distrito( $datosFormularioArray["cbodistrito"] );
    $objCliente->setPassword( $datosFormularioArray["txtcontraseña1"] );
    
    
    
        $resultado = $objCliente->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
