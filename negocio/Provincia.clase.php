<?php

require_once '../datos/Conexion.clase.php';

class Provincia extends Conexion {
    
    public function cargarProvincia($p_tipoDepartamento) {
        try {
            $sql = "SELECT *  FROM provincia Where codigo_departamento = :p_tipoDepartamento";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_tipoDepartamento", $p_tipoDepartamento);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    
}
