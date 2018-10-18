$("#btnagregar").click(function () {
    document.location.href = "venta.vista.php";
});

////

$(document).ready(function () {
    listar();
});

$("#btnfiltrar").click(function () {
    listar();
});


$("input[name='rbtipo']").change(function () {
    if ($("input[name='rbtipo']:checked").val() == 2) {
        $("#txtfecha1").prop("disabled", false);
        $("#txtfecha2").prop("disabled", false);
    } else {
        $("#txtfecha1").prop("disabled", true);
        $("#txtfecha2").prop("disabled", true);
    }
});

function listar() {

    var tipo = $("#rbtipo:checked").val();

    var fechaInicio = $("#txtfecha1").val();

    var fechaFinal = $("#txtfecha2").val();

    $.post
            (
                    "../controlador/venta.listar.controlador.php",
                    {
                        fechaInicio: fechaInicio,
                        fechaFinal: fechaFinal,
                        tipo: tipo
                    }
            ).done(function (resultado) {
        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html = "";

            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th style="text-align: center">OPCIONES</th>';

            html += '<th style="font-size:13px">N° Venta</th>';
            html += '<th style="font-size:13px">Tip Comp</th>';
            html += '<th style="font-size:13px">Serie</th>';
            html += '<th style="font-size:13px">N° Doc</th>';
            html += '<th style="font-size:13px">Fecha Venta</th>';
            html += '<th style="font-size:13px">% Igv</th>';
            html += '<th style="font-size:13px">SubTotal</th>';
            html += '<th style="font-size:13px">Igv</th>';
            html += '<th style="font-size:13px">Total</th>';
            html += '<th style="font-size:13px">Estado</th>';
            html += '<th style="font-size:13px">Cliente</th>';
            html += '<th style="font-size:13px">Ususario</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody >';

            //Detalle
            $.each(datosJSON.datos, function (i, item) {
                if (item.estado === 'EMITIDO') {
                    html += '<tr>';
                    html += '<td align="center">';
                    html += '<button type="button" style="font-size:10px; vertical-align:middle" class="btn btn-danger btn-xs" onclick="anular(' + item.numero_venta + ')" data-toggle="tooltip" data-placement="top" title="Anular"><i class="fa fa-close"></i></button>';
                    html += '&nbsp;&nbsp;';
                    html += '<button type="button" style="font-size:10px; vertical-align:middle" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal" data-toggle="tooltip" data-placement="top" title="Detalle Venta" onclick="informacion(' + item.numero_venta + ')"><i class="fa fa-navicon"></i></button>';
                    html += '</td>';
                } else {
                    html += '<tr style="text-decoration:line-through; color:red">';
                    html += '<td align="center">';
                    html += '<button disabled="" type="button" style="font-size:10px; vertical-align:middle" class="btn btn-danger btn-xs" onclick="anular(' + item.numero_venta + ')"><i class="fa fa-close"></i></button>';
                    html += '&nbsp;&nbsp;';
                    html += '<button type="button" style="font-size:10px; vertical-align:middle" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal" data-toggle="tooltip" data-placement="top" title="Detalle Venta" onclick="informacion(' + item.numero_venta + ')"><i class="fa fa-navicon"></i></button>';
                    html += '</td>';
                }

                html += '<td style="font-size:12px; vertical-align:middle" align="center">' + item.numero_venta + '</td>';
                html += '<td style="font-size:12px; vertical-align:middle" >' + item.codigo_tipo_comprobante + '</td>';
                html += '<td style="font-size:12px; vertical-align:middle" >' + item.serie + '</td>';
                html += '<td style="font-size:12px; vertical-align:middle" >' + item.numero_documento + '</td>';
                html += '<td style="font-size:12px; vertical-align:middle" >' + item.fecha_venta + '</td>';
                html += '<td style="font-size:12px; vertical-align:middle" >' + item.porcentaje_igv + '</td>';
                html += '<td style="font-size:12px; vertical-align:middle" >' + item.sub_total + '</td>';
                html += '<td style="font-size:12px; vertical-align:middle" >' + item.igv + '</td>';
                html += '<td style="font-size:12px; vertical-align:middle" >' + item.total + '</td>';
                html += '<td style="font-size:12px; vertical-align:middle" >' + item.estado + '</td>';
                html += '<td style="font-size:12px; vertical-align:middle" >' + item.cliente + '</td>';
                html += '<td style="font-size:12px; vertical-align:middle" >' + item.usuario + '</td>';

                html += '</td>';
                html += '</tr>';
            });

            html += '</tbody>';
            html += '</table>';
            html += '</small>';

            $("#listado").html(html);

            $('#tabla-listado').dataTable({
                "aaSorting": [[1, "asc"]],
                "sScrollX": "100%",
                "sScrollXInner": "150%",
                "bScrollCollapse": true,
                "bPaginate": true,
                "bProcessing": true
            });

        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }

    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });

}

function anular(numeroVenta) {
    swal({
        title: "Confirme",
        text: "¿Esta seguro de anular la venta seleccionada?",
        showCancelButton: true,
        confirmButtonColor: '#d93f1f',
        confirmButtonText: 'Si',
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: true,
        imageUrl: "../imagenes/eliminar.png"
    },
            function (isConfirm) {
                if (isConfirm) {
                    $.post(
                            "../controlador/venta.anular.controlador.php",
                            {
                                p_numero_venta: numeroVenta
                            }
                    ).done(function (resultado) {
                        var datosJSON = resultado;
                        if (datosJSON.estado === 200) { //ok
                            listar();
                            swal("Exito", datosJSON.mensaje, "success");
                        }

                    }).fail(function (error) {
                        var datosJSON = $.parseJSON(error.responseText);
                        swal("Error", datosJSON.mensaje, "error");
                    });

                }
            });

}

function informacion(numeroVenta) {
    $.post
            (
                    "../controlador/venta.listar.detalle.controlador.php",
                    {
                        numeroVenta: numeroVenta
                    }
            ).done(function (resultado) {
        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html = "";
            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tbody>';
            $.each(datosJSON.datos, function (i, item) {
                html += '<tr>';
                html += '<td style="font-size:12px; vertical-align:middle" align="center">' + item.item + '</td>';
                html += '<td style="font-size:12px; vertical-align:middle">' + item.nombre + '</td>';
                html += '<td style="font-size:12px; vertical-align:middle; text-align: right">' + item.cantidad + '</td>';
                html += '<td style="font-size:12px; vertical-align:middle; text-align: right">' + item.precio + '</td>';
                html += '<td style="font-size:12px; vertical-align:middle; text-align: right">' + item.descuento1 + '</td>';
                html += '<td style="font-size:12px; vertical-align:middle; text-align: right">' + item.descuento2 + '</td>';
                html += '<td style="font-size:12px; vertical-align:middle; text-align: right">' + item.importe + '</td>';
                html += '</tr>';

                $("#txtcodigomodal").val(item.numero_venta);
                $("#txtfechamodal").val(item.fecha_venta);
                $("#txtestadomodal").val(item.estado);
                if (item.codigo_tipo_comprobante === '03') {
                    $("#txttipocompmodal").val("BOLETA");
                } else {
                    $("#txttipocompmodal").val("FACTURA");
                }
                $("#txtseriemodal").val(item.numero_serie);
                $("#txtnrodocmodal").val(item.numero_documento);
                $("#txtporcigvmodal").val(item.porcentaje_igv);
                $("#txtigvmodal").val(item.igv);
                $("#txtsubtotalmodal").val(item.sub_total);
                $("#txttotalmodal").val(item.total);
                $("#txtclientemodal").val(item.cliente);
            });
            html += '</tbody>';
            html += '</table>';
            html += '</small>';

            $("#detalleventa-informacion").html(html);
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

// click derecho
/*
$("#listado").mousedown(function (e) {
    if (e.button == 2) {
        $("#menuCapa").css("top", e.pageY - 20);
        $("#menuCapa").css("left", e.pageX - 20);
        $("#menuCapa").show('fast');
    }
});

$("#menuCapa").mouseleave(function () {
    $("#menuCapa").hide('fast');
});

$(document).bind("contextmenu", function (e) {
    return false;
});

function anularMenu() {


}
;

function detalleMenu() {
    alert("chau")
}
;


$('#listado tbody #tabla-listado tbody tr td').on('click', function () {
    alert($(this).text());
});
*/