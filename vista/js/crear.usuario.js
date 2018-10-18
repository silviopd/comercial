$("#btncerrar").click(function () {
    document.location.href = "index.php";
});

$(document).ready(function () {
    cargarComboDepartamento("#cbodepartamento", "seleccione");
});

$("#cbodepartamento").change(function () {
    var tipoDepartamento = $("#cbodepartamento").val();
    cargarComboProvincia("#cboprovincia", "seleccione", tipoDepartamento);
});

$("#cboprovincia").change(function () {
    var tipoDepartamento = $("#cbodepartamento").val();
    var tipoProvincia = $("#cboprovincia").val();
    cargarComboDistrito("#cbodistrito", "seleccione", tipoDepartamento, tipoProvincia);
});

$("#txtnrodocumento").keypress(function (evento) {
    return validarNumeros(evento);
});

$("#txtemail").focusout(function () {
    $.post(
            "../controlador/cliente.comprobar.email.controlador.php",
            {
                p_email : $("#txtemail").val()
            }
    ).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.datos.email != null ) {
            swal("El correo ya esta creado, porfavor escriba otro", "", "warning");
            $("#txtemail").val("");
            $("#txtemail").focus();
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
})


$("#frmgrabar").submit(function (evento) {
    evento.preventDefault();
    var contra1 = $("#txtcontraseña1").val();
    var contra2 = $("#txtcontraseña2").val();
    if (contra1 === contra2) {
        swal({
            title: "Confirme",
            text: "¿Esta seguro de grabar los datos ingresados?",
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

                        $.post(
                                "../controlador/cliente.agregar.controlador.php",
                                {
                                    p_datosFormulario: $("#frmgrabar").serialize()
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
                                            document.location.href = "index.php";
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
    } else {
        swal("Contraseñas diferentes", "", "warning");
        $("#txtcontraseña1").val("");
        $("#txtcontraseña2").val("");        
        $("#txtcontraseña1").focus();
    }
});