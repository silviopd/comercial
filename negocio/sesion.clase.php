<?php

require '../datos/Conexion.clase.php';

class Sesion extends Conexion {

    private $email;
    private $clave;
    private $recordarUsuario;

    function getEmail() {
        return $this->email;
    }

    function getClave() {
        return $this->clave;
    }

    function getRecordarUsuario() {
        return $this->recordarUsuario;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function setRecordarUsuario($recordarUsuario) {
        $this->recordarUsuario = $recordarUsuario;
    }

    public function iniciarSesion($tipo) {
        if ($tipo == 2) {
            try {
                $sql = "select p.apellido_paterno,p.apellido_materno,p.nombres,u.clave,u.estado,u.codigo_usuario,c.descripcion as cargo from personal p inner join usuario u on p.dni=u.dni_usuario inner join cargo c on p.codigo_cargo=c.codigo_cargo where p.email=:p_email";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_email", $this->getEmail());
                $sentencia->execute();
                $resultado = $sentencia->fetch();

                if ($resultado["clave"] == md5($this->getClave())) {
                    if ($resultado["estado"] == "I") {
                        return 0;
                    } else {
                        session_name("SitemaComercial1");
                        session_start();

                        $_SESSION["s_nombre_usuario"] = $resultado["apellido_paterno"] . " " . $resultado["apellido_materno"] . " " . $resultado["nombres"];
                        $_SESSION["s_cargo_usuario"] = $resultado["cargo"];
                        $_SESSION["s_codigo_usuario"] = $resultado["codigo_usuario"];

                        if ($this->getRecordarUsuario() == "S") {
                            setcookie("loginusuario", $this->getEmail(), 0, "/");
                        } else {
                            setcookie("loginusuario", "", 0, "/");
                        }
                        return 1;
                    }
                } else {
                    return 2;
                }
            } catch (Exception $exc) {
                throw $exc;
            }
        } else {
            try {
                $sql = "select * from cliente where email=:p_email";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_email", $this->getEmail());
                $sentencia->execute();
                $resultado = $sentencia->fetch();

                if ($resultado["password"] == md5($this->getClave())) {
                    if ($resultado["estado"] == "I") {
                        return 0;
                    } else {
                        session_name("SitemaComercial1");
                        session_start();

                        $_SESSION["s_nombre_usuario"] = $resultado["apellido_paterno"] . " " . $resultado["apellido_materno"] . " " . $resultado["nombres"];
                        $_SESSION["s_cargo_usuario"] = "CLIENTE";
                        $_SESSION["s_codigo_usuario"] = $resultado["codigo_cliente"];

                        if ($this->getRecordarUsuario() == "S") {
                            setcookie("loginusuario", $this->getEmail(), 0, "/");
                        } else {
                            setcookie("loginusuario", "", 0, "/");
                        }
                        return 1;
                    }
                } else {
                    return 2;
                }
            } catch (Exception $exc) {
                throw $exc;
            }
        }
    }

    /*
      public function iniciarSesion() {
      try {
      $sql = "select p.apellido_paterno,p.apellido_materno,p.nombres,u.clave,u.estado,u.codigo_usuario,c.descripcion as cargo from personal p inner join usuario u on p.dni=u.dni_usuario inner join cargo c on p.codigo_cargo=c.codigo_cargo where p.email=:p_email";
      $sentencia = $this->dblink->prepare($sql);
      $sentencia->bindParam(":p_email", $this->getEmail());
      $sentencia->execute();
      $resultado = $sentencia->fetch();

      if ($resultado["clave"] == md5($this->getClave())) {
      if ($resultado["estado"] == "I") {
      return 0;
      } else {
      session_name("SitemaComercial1");
      session_start();

      $_SESSION["s_nombre_usuario"] = $resultado["apellido_paterno"] . " " . $resultado["apellido_materno"] . " " . $resultado["nombres"];
      $_SESSION["s_cargo_usuario"] = $resultado["cargo"];
      $_SESSION["s_codigo_usuario"] = $resultado["codigo_usuario"];

      if ($this->getRecordarUsuario() == "S") {
      setcookie("loginusuario", $this->getEmail(), 0, "/");
      } else {

      setcookie("loginusuario", "", 0, "/");
      }
      return 1;
      }
      } else {
      return 2;
      }
      } catch (Exception $exc) {
      throw $exc;
      }
      }
     */

    /*
      <?php
      $objSesion = new Sesion();
      echo $objSesion->captcha();
      ?>
     */

    function captcha() {
        $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz"; //posibles caracteres a usar
        $numerodeletras = 10; //numero de letras y numeros para generar el texto
        $cadena = ""; //variable para almacenar la cadena generada
        for ($i = 0; $i < $numerodeletras; $i++) {
            $cadena .= substr($caracteres, rand(0, strlen($caracteres)), 1); /* Extraemos 1 caracter de los caracteres 
              entre el rango 0 a Numero de letras que tiene la cadena */
        }
        return $cadena;
    }

//    function captcha() {
//        $caracteres = "1234567890"; //posibles caracteres a usar
//        $numerodeletras = 1; //numero de letras y numeros para generar el texto
//        $cadena = ""; //variable para almacenar la cadena generada
//        for ($i = 0; $i < $numerodeletras; $i++) {
//            $cadena .= substr($caracteres, rand(0, strlen($caracteres)), 1); /* Extraemos 1 caracter de los caracteres 
//              entre el rango 0 a Numero de letras que tiene la cadena */
//        }
//        return $cadena;
//    }
//    <?php
//                                            $objSesion = new Sesion();
//                                            
//                                            $var1=$objSesion->captcha();
//                                            setcookie("codigocaptcha1", $var1, time() + 315360000, "/");
//                                            
//                                            $var2=$objSesion->captcha();
//                                            setcookie("codigocaptcha2", $var2, time() + 315360000, "/");
//                                            
//                                            $var3=$objSesion->captcha();
//                                            setcookie("codigocaptcha3", $var3, time() + 315360000, "/");
//                                            
//                                            echo $var1." + ".$var2." + ".$var3;
//                                           
}
