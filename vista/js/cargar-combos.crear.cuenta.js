function cargarComboDepartamento(p_nombreCombo, p_tipo){
    $.post
    (
	"../controlador/departamento.cargar.combo.controlador.php"
    ).done(function(resultado){
	var datosJSON = $.parseJSON( JSON.stringify(resultado) );
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione un departamento</option>';
            }else{
                html += '<option value="0">Todos los departamentos</option>';
            }

            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_departamento+'">'+item.nombre+'</option>';
            });
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}

function cargarComboProvincia(p_nombreCombo, p_tipo,p_tipoDepartamento){
    $.post
    (
	"../controlador/provincia.cargar.combo.controlador.php",
        {
            p_tipoDepartamento: p_tipoDepartamento
        }
    ).done(function(resultado){
	var datosJSON = $.parseJSON( JSON.stringify(resultado) );
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione una provincia</option>';
            }else{
                html += '<option value="0">Todas las provincias</option>';
            }

            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_provincia+'">'+item.nombre+'</option>';
            });
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}

function cargarComboDistrito(p_nombreCombo, p_tipo,p_tipoDepartamento,p_tipoProvincia){
    $.post
    (
	"../controlador/distrito.cargar.combo.controlador.php",
        {
            p_tipoDepartamento: p_tipoDepartamento,
            p_tipoProvincia: p_tipoProvincia
        }
    ).done(function(resultado){
	var datosJSON = $.parseJSON( JSON.stringify(resultado) );
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione un distrito</option>';
            }else{
                html += '<option value="0">Todos los distritos</option>';
            }

            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_distrito+'">'+item.nombre+'</option>';
            });
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}