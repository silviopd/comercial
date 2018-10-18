<?php

require_once '../datos/Conexion.clase.php';

class Distrito extends Conexion {
    
    public function cargarDistrito($p_tipoDepartamento,$p_tipoProvincia) {
        try {
            $sql = "SELECT *  FROM distrito Where codigo_departamento = :p_tipoDepartamento and codigo_provincia = :p_tipoProvincia";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_tipoDepartamento", $p_tipoDepartamento);
            $sentencia->bindParam(":p_tipoProvincia", $p_tipoProvincia);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    
}
