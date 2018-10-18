$("#btncerrar").click(function () {
    document.location.href = "index.php";
});

$("#frmgrabar").submit(function (evento) {
    evento.preventDefault();
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
                            "../controlador/cliente.comprobar.email.controlador.php",
                            {
                                p_email: $("#txtemail").val(),
                                cbotipo: $("#cbotipo").val()
                            }
                    ).done(function (resultado) {
                        var datosJSON = resultado;
                        if (datosJSON.datos.email != null || datosJSON.datos.dni != null) {
                            $.post(
                                    "../controlador/cliente.recuperar.contrasena.controlador.php",
                                    {
                                        p_email: $("#txtemail").val(),
                                        cbotipo: $("#cbotipo").val()
                                    }
                            )
                            swal("Enviado...", "Verificar correo", "success");
                            document.location.href = "index.php";
                        } else {
                            swal("No se encontraron los datos...", "", "warning");
                            $("#txtemail").val("");
                            $("#cbotipo").val("");
                        }

                    }).fail(function (error) {
                        var datosJSON = $.parseJSON(error.responseText);
                        swal("Error", datosJSON.mensaje, "error");
                    });
                }
            });
});
