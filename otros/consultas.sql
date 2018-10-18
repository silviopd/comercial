--select2
--datepicker

SELECT * FROM area;

select * from f_generar_correlativo('venta');

select * from f_listar_venta('01-01-2016','01-01-2016',3) where numero_venta=1;

-- DROP FUNCTION f_listar_venta(date, date, integer);

select codigo_articulo,nombre,precio_venta,stock from articulo

select * from venta_detalle where numero_venta=1;

 select
                            a.*,
                            c.codigo_linea
                    from
                            articulo a 
                            inner join categoria c on ( a.codigo_categoria = c.codigo_categoria )
                    where
                            a.codigo_articulo =13;


select 
		    codigo_cliente, 
		    (apellido_paterno || ' ' || apellido_materno || ', ' || nombres) as nombre_completo, 
		    direccion, 
		    telefono_fijo, 
		    coalesce(telefono_movil1, '')  as movil1,
		    coalesce(telefono_movil2, '')  as movil2
		from 
		    cliente 