$(document).ready(function () {
    captcha();
    $("#btncaptcha").on("click",reset());
});

function reset() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 5; i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
//    document.cookie = "codigocaptcha=" + text + "; max-age=3600; path=/"
    return text;
}



//index
//<script src="js/captcha.js" type="text/javascript"></script>
//<script type="text/javascript">var aa = reset()</script>
//<?php
//echo '<script> document.write(aa) </script>';
//?>
function captcha() {

    var html = "";
    html += ' < div  class = "row" >';
    html += ' < div  class = "fila" >';
    html += ' < div  class = "col-xs-6" >';
    html += ' < div class = "form-group has-feedback" >';
    html += ' < button type = "button" class = "form-control alert-info" onclick = "window.location.reload()" >';
    html += ' < ?php';
    html += ' $objSesion = new Sesion();';
    html += ' $captcha = $objSesion - > captcha();';
    html += ' echo $captcha;';
    html += ' ? >';
    html += ' < span class = "glyphicon glyphicon-refresh form-control-feedback" > < /span>';
    html += ' < /button>';
    html += ' < /div>';
    html += ' < /div>';
    html += ' < div  class = "col-xs-6" >';
    html += ' < div class = "form-group has-feedback" >';
    html += ' < input type = "text" class = "form-control" placeholder = "Código Captcha" name = "txtcaptcha" / >';
    html += ' < span class = "glyphicon glyphicon-alert form-control-feedback" > < /span>';
    html += ' < /div>';
    html += ' < /div>';
    html += ' < /div>';
    html += ' < /div>';
    
    $("#codigoCaptcha").html(html);
}