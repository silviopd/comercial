$(document).ready(function () {
    var captcha = generarCodigoCaptcha();
    $("#btncaptcha").text(captcha);
});

$(document).on("click", "#btncaptcha", function () {
    var captcha = generarCodigoCaptcha();
    $("#btncaptcha").text(captcha);
});

function generarCodigoCaptcha() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyz0123456789";

    for (var i = 0; i < 4; i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    document.cookie = "codigocaptcha=" + text + "; max-age=3600; path=/"
    return text;
}
