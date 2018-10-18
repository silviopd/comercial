<?php

require_once '../negocio/sesion.clase.php';
require_once '../util/funciones/Funciones.clase.php';



try {


    $email = $_POST["txtusuario"];
    $clave = $_POST["txtclave"];
    $tipo = $_POST["cbotipo"];

    $_COOKIE["codigocaptcha"]; //captcha generado
//    $captchatotal = $_COOKIE["codigocaptcha1"] + $_COOKIE["codigocaptcha2"] + $_COOKIE["codigocaptcha3"];
    $captcha = $_POST["txtcaptcha"]; //capturando captcha del input


    if (isset($_POST["chkrecordar"])) {
        $recordarUsuario = $_POST["chkrecordar"];
    } else {
        $recordarUsuario = "";
    }

    $objSesion = new Sesion();
    $objSesion->setEmail($email);
    $objSesion->setClave($clave);
    $objSesion->setRecordarUsuario($recordarUsuario);

    $resultado = $objSesion->iniciarSesion($tipo);

//    session_name("intentos_name");
//    session_start();
//    
//    if ($_SESSION['intentos']<4) {
//
//            switch ($resultado) {
//                case 0:
//                    Funciones::mensaje("El usuario esta inactivo".$_SESSION['intentos'], "a", "../vista/index.php", 1.7);
//                    $_SESSION['intentos']++;
//                    break;
//
//                case 1:
//                    //Funciones::mensaje("El usuario activo","a","../vista/principal.vista.php",5);                               
//                    unset($_COOKIE["codigocaptcha"]);
//                    unset( $_SESSION['intentos']);
//                    session_destroy("intentos_name");
//                    header("location:../vista/principal.vista.php");
//                    break;
//
//                case 2:
//                    Funciones::mensaje("Contraseña incorrecta".$_SESSION['intentos'], "e", "../vista/index.php", 1.7);
//                    $_SESSION['intentos']++;
//                    break;
//
//                default:
//                    break;
//            }
//    } else {
    if ($_COOKIE["codigocaptcha"] == $captcha) {

        switch ($resultado) {
            case 0:
                Funciones::mensaje("El usuario esta inactivo", "a", "../vista/index.php", 1.7);
                break;

            case 1:
                //Funciones::mensaje("El usuario activo","a","../vista/principal.vista.php",5);                               
                unset($_COOKIE["codigocaptcha"]);
                header("location:../vista/principal.vista.php");
                break;

            case 2:
                Funciones::mensaje("Contraseña incorrecta", "e", "../vista/index.php", 1.7);
                break;

            default:
                break;
        }
    } else {
        Funciones::mensaje("captcha incorrecto", "a", "../vista/index.php", 1.7);
    }
//    }
} catch (Exception $exc) {
    Funciones::mensaje($exc->getMessage(), "e");
}



