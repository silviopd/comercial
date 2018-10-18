$("#btncerrar").click(function () {
    document.location.href = "principal.vista.php";
});

$("#txtcontrasenaactual").focusout(function () {
    $.post(
            "../controlador/validar.contrasena.controlador.php",
            {
                p_contra : $("#txtcontrasenaactual").val()
            }
    ).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200 ) {
            swal("El correo ya esta creado, correcto", "", "warning");
        }
    })
    swal("FALSISISMO!", "", "warning");
})

