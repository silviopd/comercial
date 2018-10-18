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
                <a href="../../index2.html"><h3><?php echo C_NOMBRE_SOFTWARE; ?> - Crear Cuenta </h3></a>
            </div><!-- /.login-logo -->

            <div class = "row">
                <form class="form-horizontal" id="frmgrabar">
                    <fieldset>
                        <legend>Datos Personales</legend>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Nombre</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="txtnombre" name="txtnombre" placeholder="(Obligatorio)" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Apellido Materno</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="txtapellidopaterno" name="txtapellidopaterno" placeholder="(Obligatorio)" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="col-lg-3 control-label">Apellido Paterno</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="txtapellidomaterno" name="txtapellidomaterno" placeholder="(Obligatorio)" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email</label>
                            <div class="col-lg-9">
                                <input type="email" class="form-control" id="txtemail" name="txtemail" placeholder="(Obligatorio)" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="col-lg-3 control-label">N° Documento</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="txtnrodocumento" name="txtnrodocumento" placeholder="(Obligatorio)" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Direccion</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="txtdireccion" name="txtdireccion" placeholder="(Obligatorio)" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Telefono Fijo(*)</label>
                            <div class="col-lg-9">
                                <input type="number" class="form-control" id="txttelefonofijo" name="txttelefonofijo" placeholder="(opcional)">
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="col-lg-3 control-label">Telefono Movil 1(*)</label>
                            <div class="col-lg-9">
                                <input type="number" class="form-control" id="txttelefonomovil1" name="txttelefonomovil1" placeholder="(opcional)">
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="col-lg-3 control-label">Telefono Movil 2(*)</label>
                            <div class="col-lg-9">
                                <input type="number" class="form-control" id="txttelefonomovil2" name="txttelefonomovil2" placeholder="(opcional)">
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="col-lg-3 control-label">Departamento</label>
                            <div class="col-lg-9">
                                <select class="form-control" id="cbodepartamento" name="cbodepartamento" required="">
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Provincia</label>
                            <div class="col-lg-9">
                                <select class="form-control" id="cboprovincia" name="cboprovincia" required="">
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="col-lg-3 control-label">Distrito</label>
                            <div class="col-lg-9">
                                <select class="form-control" id="cbodistrito" name="cbodistrito" required="">
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="col-lg-3 control-label">Ingrese Contraseña</label>
                            <div class="col-lg-9">
                                <input type="password" class="form-control" id="txtcontraseña1" name="txtcontraseña1" placeholder="(Obligatorio)">
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="col-lg-3 control-label">Confirme Contraseña</label>
                            <div class="col-lg-9">
                                <input type="password" class="form-control" id="txtcontraseña2" name="txtcontraseña2" placeholder="(Obligatorio)">
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

        <script src="../vista/js/cargar-combos.crear.cuenta.js" type="text/javascript"></script>
        <script src="../vista/js/crear.usuario.js" type="text/javascript"></script>
        <script src="../vista/js/util.js" type="text/javascript"></script>
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