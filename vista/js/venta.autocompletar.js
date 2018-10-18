/*INICIO: BUSQUEDA DE CLIENTES*/
$("#txtnombrecliente").autocomplete({
    source: "../controlador/cliente.autocompletar.controlador.php",
    minLength: 1, //Filtrar desde que colocamos 2 o mas caracteres
    focus: f_enfocar_registro_cliente,
    select: f_seleccionar_registro_cliente
});

function f_enfocar_registro_cliente(event, ui) {
    var registro = ui.item.value;
    $("#txtnombrecliente").val(registro.nombre);
    event.preventDefault();
}
/*FIN: BUSQUEDA DE CLIENTES*/


/*INICIO: LLENAR CLIENTE CON ENTER*/
function f_seleccionar_registro_cliente(event, ui) {
    var registro = ui.item.value;
    $("#txtnombrecliente").val(registro.nombre);
    $("#txtcodigocliente").val(registro.codigo);
    $("#lbldireccioncliente").val(registro.direccion);
    $("#lbltelefonocliente").val(registro.telefono);

    $("#txtarticulo").focus();

    event.preventDefault();
}
/*FIN: LLENAR CLIENTE CON ENTER*/





/*INICIO: BUSQUEDA DE ARTICULOS*/
$("#txtarticulo").autocomplete({
    source: "../controlador/articulo.autocompletar.controlador.php",
    minLength: 1, //Filtrar desde que colocamos 2 o mas caracteres
    focus: f_enfocar_registro_articulos,
    select: f_seleccionar_registro_articulos
});

function f_enfocar_registro_articulos(event, ui) {
    var registro = ui.item.value;
    $("#txtarticulo").val(registro.nombre);
    event.preventDefault();
}
/*FIN: BUSQUEDA DE ARTICULOS*/

/*INICIO: LLENAR ARTICULO CON ENTER*/
function f_seleccionar_registro_articulos(event, ui) {
    var registro = ui.item.value;
    $("#txtarticulo").val(registro.nombre);
    $("#txtcodigoarticulo").val(registro.codigo);
    
    $("#txtstock").val(registro.stock);
    $("#txtprecio").val(registro.precio);

    $("#txtcantidad").focus();

    event.preventDefault();
}
/*FIN: LLENAR ARTICULO CON ENTER*/