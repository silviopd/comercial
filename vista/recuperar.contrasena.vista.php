<?php
require_once '../util/funciones/definiciones.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo C_NOMBRE_SOFTWARE; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <?php
        include 'estilos.vista.php';
        ?>

        <!-- iCheck -->
        <link href="../util/lte/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
        <!-- box-msg -->
        <link href="../util/bootstrap/css/box-msg.css" rel="stylesheet" type="text/css" />              

    </head>
    <body class="login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="../../index2.html"><h3><?php echo C_NOMBRE_SOFTWARE; ?> - Recuperar Contraseña </h3></a>
            </div><!-- /.login-logo -->

            <div class = "row">
                <form class="form-horizontal" id="frmgrabar">
                    <fieldset>
                        <legend>Ingrese los datos</legend>

                        <div class="form-group">
                            <label  class="col-lg-3 control-label">Tipo</label>
                            <div class="col-lg-9">
                                <select class="form-control" id="cbotipo" name="cbotipo" required="" >
                                    <option value="" disabled selected>Seleccione un tipo</option>
                                    <option value="1" >Cliente</option>
                                    <option value="2" >Personal</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email</label>
                            <div class="col-lg-9">
                                <input type="email" class="form-control" id="txtemail" name="txtemail" placeholder="(Obligatorio)" required="">
                            </div>
                        </div>                        

                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-4">
                                <button type="submit" class="btn btn-success" aria-hidden="true"><i class="fa fa-save"></i> Grabar</button>
                                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  
                                <button type="button" class="btn btn-default" data-dismiss="modal" id="btncerrar" name="btncerrar"><i class="fa fa-close"></i> Cerrar</button>

                            </div>
                        </div>
                        <legend></legend>
                    </fieldset>
                </form>

            </div>

        </div><!-- /.login-box -->

        <?php
        include 'scripts.vista.php';
        ?>
        <!-- iCheck -->
        <script src="../util/lte/plugins/iCheck/icheck.js" type="text/javascript"></script>
        
        <script src="js/recuperar.contrasena.usuario.js" type="text/javascript"></script>

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