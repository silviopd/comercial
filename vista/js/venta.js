$("#btnregresar").click(function () {
    document.location.href = "venta.listado.vista.php";
});

$(document).ready(function () {
    cargarComboTC("#cbotipocomp", "seleccione");
    obtenerPorcentajeIGV();
});

$("#cbotipocomp").change(function () {
    var tipoComprobante = $("#cbotipocomp").val();
    cargarComboSerie("#cboserie", "seleccione", tipoComprobante);
    $("#txtnrodoc").val("");
});

function obtenerNumeroComprobante() {
    var tipoComprobante = $("#cbotipocomp").val();
    var serie = $("#cboserie").val();
//    alert(tipoComprobante+"  "+serie);
    $.post
            (
                    "../controlador/serie.comprobante.obtener.numero.controlador.php",
                    {
                        p_tipoComprobante: tipoComprobante,
                        p_serie: serie
                    }
            ).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var numeroComprobante = datosJSON.datos.numero;
//                alert(numeroComprobante);
            $("#txtnrodoc").val(numeroComprobante);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });

}

$("#cboserie").change(function () {
    obtenerNumeroComprobante();
});

$("#btnagregar").click(function () {
//    variable = (condicion) ? (accion si es verdadero) : (accion si es falso)
    if ($("#txtcodigoarticulo").val().toString() == '') {
        swal("Verifique", "Debese seleccionar un articulo", "warning");
        $("#txtarticulo").focus();
        return 0;
    }

    var codigoArticulo = $("#txtcodigoarticulo").val();
    var nombreArticulo = $("#txtarticulo").val();
    var precioVenta = $("#txtprecio").val();
    var cantidad = $("#txtcantidad").val();
    var stock = $("#txtstock").val();

    //validación cantidad
//    if (isNaN(cantidad)) {
//        swal("Verifique", "Debes solo ingresar números", "error");
//        $("#txtcantidad").focus();
//        return 0;
//    }else 

    if (cantidad > stock ) {
        swal("Verifique", "Cantidad pasa el stock", "warning");
        $("#txtcantidad").focus();
        return 0;
    }

    var importe = cantidad * precioVenta;

    //fila para llenar la tabla html en js
    var fila = '<tr>' +
            '<td class="text-center" style="vertical-align:middle;">' + codigoArticulo + '</td>' +
            '<td style="vertical-align:middle;">' + nombreArticulo + '</td>' +
            '<td class="text-right" style="vertical-align:middle;">' + precioVenta + '</td>' +
            '<td class="text-right" style="vertical-align:middle;">' + cantidad + '</td>' +
            '<td class="text-right" style="vertical-align:middle;">' + parseFloat(importe).toFixed(2) + '</td>' +
            '<td id="celiminar" class="text-center" style="font-size:20px" ><a href="javascript:void()"><i class="fa fa-close text-danger"></i></a></td>' +
            '</tr>';

    //agregar
    $("#detalleventa").append(fila);
    calcularTotales();

    //limpiar
    $("#txtcodigoarticulo").val("");
    $("#txtarticulo").val("");
    $("#txtprecio").val("");
    $("#txtcantidad").val("");
    $("#txtstock").val("");

    $("#txtarticulo").focus();
});

//ELIMINAR
$(document).on("click", "#celiminar", function () {
    var filaEliminar = $(this).parents().get(0);

    swal({
        title: "Confirme",
        text: "¿Desea eliminar el registro seleccionado?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#ff0000',
        confirmButtonText: 'Si',
        cancelButtonText: "No",
        closeOnConfirm: true,
        closeOnCancel: true
    },
            function (isConfirm) {

                if (isConfirm) { //el usuario hizo clic en el boton SI     
                    filaEliminar.remove();//<-elimina                    
                    calcularTotales();
                    $("#txtarticulo").focus();
                }
            });
});

function calcularTotales() {
    var subTotal = 0;
    var igv = 0;
    var neto = 0;

    //capturando datos
    $("#detalleventa tr").each(function () {
        var importe = $(this).find("td").eq(4).html();
        neto += parseFloat(importe);
    });

    var porcentajeIGV = $("#txtigv").val();
    subTotal = neto / (1 + porcentajeIGV / 100);
    igv = neto - subTotal;

    //asignando
    $("#txtimporteneto").val(neto.toFixed(2));
    $("#txtimporteigv").val(igv.toFixed(2));
    $("#txtimportesubtotal").val(subTotal.toFixed(2));
}

//eliminar backspace(codigo articulo)
$(document).on("keydown", "#txtarticulo", function (e) {
    if (e.keyCode == 8) {
        $("#txtcodigoarticulo").val("");
        $("#txtprecio").val("");
        $("#txtcantidad").val("");
        $("#txtstock").val("");
    }
});

//eliminar backspace(codigo cliente)
$(document).on("keydown", "#txtnombrecliente", function (e) {
    if (e.keyCode == 8) {
        $("#txtcodigocliente").val("");
        $("#lbldireccioncliente").val("");
        $("#lbltelefonocliente").val("");
    }
});

//validación cantidad
$("#txtcantidad").keypress(function (evento) {
    if (evento.which == 13) {
        evento.preventDefault();
        $("#btnagregar").click();
    } else {
        return validarNumeros(evento);
    }
});

function obtenerPorcentajeIGV() {
    $.post
            (
                    "../controlador/configuracion.controlador.php",
                    {
                        p_codigo_parametro: 1
                    }
            ).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var valorObtenido = datosJSON.datos;
            $("#txtigv").val(valorObtenido);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

//transaccion agregar

var arrayDetalle = new Array(); //permite almacenar todos los articulos agregados en el detalle de la venta

$("#frmgrabar").submit(function (evento) {
    evento.preventDefault();

    swal({
        title: "Confirme",
        text: "¿Esta seguro de grabar la venta?",
        showCancelButton: true,
        confirmButtonColor: '#3d9205',
        confirmButtonText: 'Si',
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: true,
        imageUrl: "../imagenes/pregunta.png"
    },
            function (isConfirm) {

                if (isConfirm) { //el usuario hizo clic en el boton SI     

                    //procedo a grabar

                    /*CAPTURAR TODOS LOS DATOS NECESARIOS PARA GRABAR EN EL VENTA_DETALLE*/

                    /*limpiar el array*/
                    arrayDetalle.splice(0, arrayDetalle.length);
                    /*limpiar el array*/

                    /*RECORREMOS CADA FILA DE LA TABLA DONDE ESTAN LOS ARTICULOS VENDIDOS*/
                    $("#detalleventa tr").each(function () {
                        var codigoArticulo = $(this).find("td").eq(0).html();
                        var precio = $(this).find("td").eq(2).html();
                        var cantidad = $(this).find("td").eq(3).html();
                        var importe = $(this).find("td").eq(4).html();

                        var objDetalle = new Object(); //Crear un objeto para almacenar los datos

                        /*declaramos y asignamos los valores a los atributos*/
                        objDetalle.codigoArticulo = codigoArticulo;
                        objDetalle.cantidad = cantidad;
                        objDetalle.precio = precio;
                        objDetalle.importe = importe;
                        /*declaramos y asignamos los valores a los atributos*/

                        arrayDetalle.push(objDetalle); //agregar el objeto objDetalle al array arrayDetalle

                    });

                    /*RECORREMOS CADA FILA DE LA TABLA DONDE ESTAN LOS ARTICULOS VENDIDOS*/

                    //Convertimos el array "arrayDetalle" a formato de JSON
                    var jsonDetalle = JSON.stringify(arrayDetalle);

//                    alert(jsonDetalle);
//                    return 0;


                    /*CAPTURAR TODOS LOS DATOS NECESARIOS PARA GRABAR EN EL VENTA_DETALLE*/

                    $.post(
                            "../controlador/venta.agregar.controlador.php",
                            {
                                p_datosFormulario: $("#frmgrabar").serialize(),
                                p_datosJSONDetalle: jsonDetalle
                            }
                    ).done(function (resultado) {
                        var datosJSON = resultado;

                        if (datosJSON.estado === 200) {
                            swal({
                                title: "Exito",
                                text: datosJSON.mensaje,
                                type: "success",
                                showCancelButton: false,
                                //confirmButtonColor: '#3d9205',
                                confirmButtonText: 'Ok',
                                closeOnConfirm: true,
                            },
                                    function () {
                                        document.location.href = "venta.listado.vista.php";
                                    });
                        } else {
                            swal("Mensaje del sistema", resultado, "warning");
                        }

                    }).fail(function (error) {
                        var datosJSON = $.parseJSON(error.responseText);
                        swal("Error", datosJSON.mensaje, "error");
                    });

                }
            });
});