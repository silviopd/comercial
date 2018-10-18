<?php

require_once '../datos/Conexion.clase.php';

class Venta extends Conexion {

    private $numero_venta;
    private $codigo_tipo_comprobante;
    private $numero_serie;
    private $numero_documento;
    private $codigo_cliente;
    private $fecha_venta;
    private $porcentaje_igv;
    private $sub_total;
    private $igv;
    private $total;
    private $codigo_usuario;
    private $detalleVenta; //JSON

    function getNumero_venta() {
        return $this->numero_venta;
    }

    function getCodigo_tipo_comprobante() {
        return $this->codigo_tipo_comprobante;
    }

    function getNumero_serie() {
        return $this->numero_serie;
    }

    function getNumero_documento() {
        return $this->numero_documento;
    }

    function getCodigo_cliente() {
        return $this->codigo_cliente;
    }

    function getFecha_venta() {
        return $this->fecha_venta;
    }

    function getPorcentaje_igv() {
        return $this->porcentaje_igv;
    }

    function getSub_total() {
        return $this->sub_total;
    }

    function getIgv() {
        return $this->igv;
    }

    function getTotal() {
        return $this->total;
    }

    function getCodigo_usuario() {
        return $this->codigo_usuario;
    }

    function getDetalleVenta() {
        return $this->detalleVenta;
    }

    function setNumero_venta($numero_venta) {
        $this->numero_venta = $numero_venta;
    }

    function setCodigo_tipo_comprobante($codigo_tipo_comprobante) {
        $this->codigo_tipo_comprobante = $codigo_tipo_comprobante;
    }

    function setNumero_serie($numero_serie) {
        $this->numero_serie = $numero_serie;
    }

    function setNumero_documento($numero_documento) {
        $this->numero_documento = $numero_documento;
    }

    function setCodigo_cliente($codigo_cliente) {
        $this->codigo_cliente = $codigo_cliente;
    }

    function setFecha_venta($fecha_venta) {
        $this->fecha_venta = $fecha_venta;
    }

    function setPorcentaje_igv($porcentaje_igv) {
        $this->porcentaje_igv = $porcentaje_igv;
    }

    function setSub_total($sub_total) {
        $this->sub_total = $sub_total;
    }

    function setIgv($igv) {
        $this->igv = $igv;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    function setCodigo_usuario($codigo_usuario) {
        $this->codigo_usuario = $codigo_usuario;
    }

    function setDetalleVenta($detalleVenta) {
        $this->detalleVenta = $detalleVenta;
    }

    public function agregar() {
        $this->dblink->beginTransaction();
        try {
            $sql = "select * from f_generar_correlativo('venta') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();

            if ($sentencia->rowCount()) {
                $nuevoNumeroVenta = $resultado["nc"];
                $this->setNumero_venta($nuevoNumeroVenta);

                $sql = "INSERT INTO venta (numero_venta, codigo_tipo_comprobante, numero_serie, numero_documento,codigo_cliente, fecha_venta, porcentaje_igv, sub_total, igv,total,codigo_usuario)
                        VALUES (:p_numero_venta,:p_codigo_tipo_comprobante ,:p_numero_serie, :p_numero_documento,:p_codigo_cliente, :p_fecha_venta, :p_porcentaje_igv, :p_sub_total, :p_igv,:p_total, :p_codigo_usuario);";

                $sentencia = $this->dblink->prepare($sql);

                $sentencia->bindParam(":p_numero_venta", $this->getNumero_venta());
                $sentencia->bindParam(":p_codigo_tipo_comprobante", $this->getCodigo_tipo_comprobante());
                $sentencia->bindParam(":p_numero_serie", $this->getNumero_serie());
                $sentencia->bindParam(":p_numero_documento", $this->getNumero_documento());
                $sentencia->bindParam(":p_codigo_cliente", $this->getCodigo_cliente());
                $sentencia->bindParam(":p_fecha_venta", $this->getFecha_venta());
                $sentencia->bindParam(":p_porcentaje_igv", $this->getPorcentaje_igv());
                $sentencia->bindParam(":p_sub_total", $this->getSub_total());
                $sentencia->bindParam(":p_igv", $this->getIgv());
                $sentencia->bindParam(":p_total", $this->getTotal());
                $sentencia->bindParam(":p_codigo_usuario", $this->getCodigo_usuario());

                $sentencia->execute();

                /* INSERTAR EN LA TABLA VENTA_DETALLE */
                $detalleVentaArray = json_decode($this->getDetalleVenta()); //Convertir de formato JSON a formato array


                $item = 0;

                foreach ($detalleVentaArray as $key => $value) { //permite recorrer el array
                    $sql = "select stock,nombre from articulo where codigo_articulo=:p_codigo_articulo;";
                    $sentencia = $this->dblink->prepare($sql);
                    $sentencia->bindParam(":p_codigo_articulo", $value->codigoArticulo);
                    $sentencia->execute();
                    $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
                    if ($resultado["stock"] < $value->cantidad) {
                        throw new Exception("No hay stock suficiente" . " \n" . " Articulo: " . $value->codigoArticulo . " - " . $resultado["nombre"] . "\n" . " stock actual: " . $resultado["stock"] . "\n" . "cantidad de venta: " . $value->cantidad);
                    }

                    $sql = "INSERT INTO venta_detalle (numero_venta,item,codigo_articulo,cantidad,precio,descuento1,descuento2,importe)
                            VALUES (:p_numero_venta,:p_item,:p_codigo_articulo,:p_cantidad,:p_precio,:p_descuento1,:p_descuento2,:p_importe);";


                    //Preparar la sentencia
                    $sentencia = $this->dblink->prepare($sql);

                    $item++;

                    //Asignar un valor a cada parametro
                    $sentencia->bindParam(":p_numero_venta", $this->getNumero_venta());
                    $sentencia->bindParam(":p_item", $item);
                    $sentencia->bindParam(":p_codigo_articulo", $value->codigoArticulo);
                    $sentencia->bindParam(":p_cantidad", $value->cantidad);
                    $sentencia->bindParam(":p_precio", $value->precio);

                    $descuento1 = 0;
                    $descuento2 = 0;

                    $sentencia->bindParam(":p_descuento1", $descuento1);
                    $sentencia->bindParam(":p_descuento2", $descuento2);
                    $sentencia->bindParam(":p_importe", $value->importe);


                    //Ejecutar la sentencia preparada
                    $sentencia->execute();

                    $sql = "update articulo set stock = stock-:p_cantidad where codigo_articulo = :p_codigo_articulo";
                    $sentencia = $this->dblink->prepare($sql);
                    $sentencia->bindParam(":p_cantidad", $value->cantidad);
                    $sentencia->bindParam(":p_codigo_articulo", $value->codigoArticulo);
                    $sentencia->execute();
                }
                /* INSERTAR EN LA TABLA VENTA_DETALLE */

                //Actualizar el correlativo(venta) en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'venta'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();

                //Actualizar el correlativo(serie_comprobante) en +1
                $sql = "UPDATE serie_comprobante  SET numero_documento=numero_documento+1 WHERE codigo_tipo_comprobante=:p_codigo_tipo_comprobante AND numero_serie=:p_numero_serie;";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_codigo_tipo_comprobante", $this->getCodigo_tipo_comprobante());
                $sentencia->bindParam(":p_numero_serie", $this->getNumero_serie());
                $sentencia->execute();

                //Terminar la transacción
                $this->dblink->commit();


                return true;
            } else {
                throw new Exception("No se ha configurado el correlativo para la tabla venta");
            }
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        return false;
    }

    public function listar($p_fecha1, $p_fecha2, $p_tipo) {
        try {
            $sql = "select * from f_listar_venta(:p_fecha1, :p_fecha2, :p_tipo)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_fecha1", $p_fecha1);
            $sentencia->bindParam(":p_fecha2", $p_fecha2);
            $sentencia->bindParam(":p_tipo", $p_tipo);
            $sentencia->execute();

            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function anular($numeroVenta) {
        $this->dblink->beginTransaction();
        try {
            $sql = "update venta set estado = 'A' where numero_venta = :p_numero_venta";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_numero_venta", $numeroVenta);
            $sentencia->execute();

            $sql = "select codigo_articulo, cantidad from venta_detalle where numero_venta = :p_numero_venta";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_numero_venta", $numeroVenta);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            for ($i = 0; $i < count($resultado); $i++) {
                $sql = "update articulo set stock = stock + :p_cantidad where codigo_articulo = :p_codigo_articulo";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_cantidad", $resultado[$i]["cantidad"]);
                $sentencia->bindParam(":p_codigo_articulo", $resultado[$i]["codigo_articulo"]);
                $sentencia->execute();
            }

            //Terminar la transacción
            $this->dblink->commit();

            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
    }

//     public function listarVentaDetalle($numeroVenta) {
//          try {
//            $sql = "SELECT venta_detalle.numero_venta,venta_detalle.item, articulo.nombre, venta_detalle.cantidad, venta_detalle.precio, venta_detalle.descuento1, venta_detalle.descuento2, venta_detalle.importe FROM public.articulo, public.venta_detalle WHERE articulo.codigo_articulo = venta_detalle.codigo_articulo AND numero_venta=:p_numero_venta";
//            $sentencia = $this->dblink->prepare($sql);
//            $sentencia->bindParam(":p_numero_venta", $numeroVenta);
//            $sentencia->execute();
//
//            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
//
//            return $resultado;
//        } catch (Exception $exc) {
//            throw $exc;
//        }
//     }

    public function listarVentaDetalle($numeroVenta) {
        try {
            $sql = "SELECT venta.numero_venta,venta.fecha_venta,(case when venta.estado='E' then 'EMITIDO' else 'ANULADO' end)::varchar estado,venta.codigo_tipo_comprobante,venta.numero_serie,venta.numero_documento,venta.porcentaje_igv,venta.igv,venta.sub_total,venta.total,venta_detalle.item,articulo.nombre,venta_detalle.cantidad,venta_detalle.precio,venta_detalle.descuento1,venta_detalle.descuento2,venta_detalle.importe,upper(cliente.apellido_paterno||' '||cliente.apellido_materno||', '||cliente.nombres)::varchar cliente FROM public.articulo,public.cliente,public.venta,public.venta_detalle WHERE venta.numero_venta = venta_detalle.numero_venta AND venta.codigo_cliente = cliente.codigo_cliente AND venta_detalle.codigo_articulo = articulo.codigo_articulo AND venta.numero_venta =:p_numero_venta";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_numero_venta", $numeroVenta);
            $sentencia->execute();

            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

}
