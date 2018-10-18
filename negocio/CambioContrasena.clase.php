<?php

require_once '../datos/Conexion.clase.php';

class CambioContrasena extends Conexion {

    public function nuevaContra($email, $tipo) {
        $aleatorio;
        try {
            if ($tipo == 1) {
                $sql = "UPDATE cliente
                        SET password=md5(:p_password)
                        WHERE email=:p_email";
                $sentencia = $this->dblink->prepare($sql);
                $aleatorio = $this->captcha();
                $sentencia->bindParam(":p_password", $aleatorio);
                $sentencia->bindParam(":p_email", $email);
                $sentencia->execute();
                return $aleatorio;
            } else {
                $aleatorio = $this->captcha();
                $sql = "select dni from personal where email=:p_email";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_email", $email);
                $sentencia->execute();
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

                $dni = $resultado["dni"];

                $sql = "UPDATE usuario  SET clave=md5(:p_password) WHERE dni_usuario=:p_dni_usuario";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_password", $aleatorio);
                $sentencia->bindParam(":p_dni_usuario", $dni);
                $sentencia->execute();

                return $aleatorio;
            }
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    function captcha() {
        $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz"; //posibles caracteres a usar
        $numerodeletras = 10; //numero de letras y numeros para generar el texto
        $cadena = ""; //variable para almacenar la cadena generada
        for ($i = 0; $i < $numerodeletras; $i++) {
            $cadena .= substr($caracteres, rand(0, strlen($caracteres)), 1); /* Extraemos 1 caracter de los caracteres 
              entre el rango 0 a Numero de letras que tiene la cadena */
        }
        return $cadena;
    }

    public function validarcontrasena($contra) {
        try {
            session_name("SitemaComercial1");
            session_start();
            
//            return $_SESSION["s_codigo_usuario"];
            
//            if ($_SESSION["s_cargo_usuario"]=='CLIENTE') {                
//                $codigo=$_SESSION["s_codigo_usuario"];                
//                $sql = "select * from cliente where codigo_cliente=:p_codigo_cliente";
//                $sentencia = $this->dblink->prepare($sql);
//                $sentencia->bindParam(":p_codigo_cliente", $codigo);
//                $sentencia->execute();
//                return true;
//            }else{
                               
                $sql = "select * from usuario where codigo_usuario=:p_codigo_usuario and clave=md5(:p_clave)";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_codigo_usuario",$_SESSION["s_codigo_usuario"]);
                $sentencia->bindParam(":p_clave", $contra);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
//            }
        } catch (Exception $exc) {
            throw $exc;
        }
        return false;
    }

}
