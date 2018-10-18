<?php

require_once '../datos/Conexion.clase.php';

class Configuracion extends Conexion {

    public function obtenerValorConfiguracion($p_codigoParametro) {
        try {
            $sql = "select valor from configuracion where codigo=:p_codigoParametro";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigoParametro", $p_codigoParametro);
            $sentencia->execute();
            //filas y columnas (fetchAll)
//            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);            
//            return $resultado[0]["valor"];
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado["valor"];
        } catch (Exception $exc) {
            throw $exc;
        }
    }

}
