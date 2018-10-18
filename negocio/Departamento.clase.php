<?php

require_once '../datos/Conexion.clase.php';

class Departamento extends Conexion {
    

    public function cargarDepartamento(){
        try {
            $sql = "select * from departamento order by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    
}
