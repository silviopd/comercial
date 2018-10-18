<?php
if (isset($_COOKIE["loginusuario"])) {
    $loginUsuario = $_COOKIE["loginusuario"];
} else {
    $loginUsuario = "";
}

require_once '../util/funciones/definiciones.php';

require_once '../negocio/sesion.clase.php';

//session_name("intentos_name");
//session_start();
//$_SESSION['intentos'] = $_SESSION['intentos']+1;

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo C_NOMBRE_SOFTWARE; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="../util/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="../util/lte/css/font-awesome.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../util/lte/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="../util/lte/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
        <!-- box-msg -->
        <link href="../util/bootstrap/css/box-msg.css" rel="stylesheet" type="text/css" />

    </head>
    <body class="login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="../../index2.html"><h3><?php echo C_NOMBRE_SOFTWARE; ?></h3></a>
            </div><!-- /.login-logo -->

            <div class = "row">
                <div class = "col-xs-3">
                    <div class="">
                        <img src="../imagenes/logo2.jpg" style="width:210%; height: 338px"/>
                    </div>
                </div>
                <div class = "col-xs-2">
                </div>
                <div class = "col-xs-4">
                    <div class="login-box-body">
                        <p class="login-box-msg">
                            Ingrese sus datos para iniciar sesión</p>

                        <form action="../controlador/sesion.iniciar.controlador.php" method="post">
                            <div class="form-group">
                                <select class="form-control" id="cbotipo" name="cbotipo" required="" >
                                    <option value="" disabled selected>Seleccione un tipo</option>
                                    <option value="1" >Cliente</option>
                                    <option value="2" >Personal</option>
                                </select>
                            </div>
                            
                            <div class="form-group has-feedback">
                                <input type="email" class="form-control" placeholder="Usuario" autofocus="" name="txtusuario" required="" value="<?php echo $loginUsuario; ?>" />
                                <span class="glyphicon glyphicon-user form-control-feedback text-blue"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <input type="password" class="form-control" placeholder="Contraseña" name="txtclave"/>
                                <span class="glyphicon glyphicon-lock form-control-feedback text-yellow"></span>
                            </div>

                            <!--codigo captcha-->
                            <div  class = "row" id="frmcaptcha" >
                                <div  class = "col-xs-6" >
                                    <div class="form-group has-feedback">
                                        <button type="button" class="form-control alert-info" id="btncaptcha" name="btncaptcha">                                            
                                        <!--  Captcha -->                                      
                                            
                                        </button>
                                        <span class="glyphicon glyphicon-refresh form-control-feedback text-bold"></span>
                                    </div>
                                </div>
                                <div  class = "col-xs-6" >
                                    <div class="form-group has-feedback" >
                                        <input type="text" class="form-control" placeholder="Código Captcha" name="txtcaptcha" >
                                        <span class="glyphicon glyphicon-alert form-control-feedback text-red"></span>
                                    </div>
                                </div>
                            </div>


<!--                            <script src="../util/jquery/jquery.min.js"></script>
<script>
                    $(document).ready(function () {
                        alert($("#btncaptcha").text());
                    });
</script>
                            <!--fin codigo captcha-->

                            <div class="row">
                                <div class="col-xs-8">
                                    <div class="checkbox icheck">
                                        <label>
                                            <input type="checkbox" name="chkrecordar" value="S"> Recordar datos
                                        </label>
                                    </div>
                                </div><!-- /.col -->
                                <div class="col-xs-4">
                                    <button type="submit" class="btn btn-success btn-block btn-flat">Ingresar</button>
                                    
                                </div><!-- /.col -->
                            </div>
                        </form>
                        <a href="crear.cuenta.vista.php">Crear Cuenta</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        <a href="recuperar.contrasena.vista.php">Recuperar Contraseña</a><br>
                    </div><!-- /.login-box-body -->
                </div>
            </div>

        </div><!-- /.login-box -->

        <div class="box-footer">
            El acceso proporciona información de carácter CONFIDENCIAL, por esta razón durante la sesión, todas las acciones del usuario pueden AUDITADAS; es decir, se generarán reportes de uso y son de responsabilidad absoluta del usuario. No debe compartir su usuario ni contraseña, ni proporcionar información a personas ajenas a estas, toda consulta deberá ser realizada mediante documentación sustentatoria. El USUARIO y CONTRASEÑA son personales e intransferibles. Tome sus medidas de seguridad.
        </div>

        <!-- jQuery 2.1.3 -->
        <script src="../util/jquery/jquery.min.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="../util/bootstrap/js/bootstrap.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="../util/lte/plugins/iCheck/icheck.js" type="text/javascript"></script>
        <!--Captcha-->
        <script src="../vista/js/captcha.js" type="text/javascript"></script>
        <script>
                                            $(function () {
                                                $('input').iCheck({
                                                    checkboxClass: 'icheckbox_square-blue',
                                                    radioClass: 'iradio_square-blue',
                                                    increaseArea: '20%' // optional
                                                });
                                            });
        </script>
    </body>
</html>