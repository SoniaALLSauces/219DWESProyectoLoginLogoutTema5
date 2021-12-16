<?php

    /* 
     * Author: Sonia Antón Llanes
     * Created on: 15-diciembre-2021
     * Last Modify: 15-diciembre-2021
     * LOGIN: ventana para iniciar sesion de un usuario guardado en una tabla 'usuarios' de la base de datos
     */

        /* Si pulsamos el boton CANCELAR */
            if (isset($_REQUEST['cancelar'])){
                header('Location: programa.php');  //redirige a la fichero programa.php
                exit;
            }
        
            
        /* INICIO LA SESION */
            session_start();
        /*Recupero variable que necesito para acceder a los datos del usuario logeado*/
            $usuario= $_SESSION['UsuarioDAW219AppLoginLogout'];
        
            
        /* EDITAR: Importamos archivos necesarios */
            require_once '../config/confDBPDO.php';  //archivo que contiene los parametros de la conexion
            require_once '../core/libreriaValidacion.php'; //libreria Validación para errores

        /* CONECTO A LA BASE DE DATOS PARA ACCDER A LOS DATOS DEL USUARIO Y MOSTRAR EN EL FORMULARIO */
            try{
                $miDB = new PDO (HOST, USER, PASSWORD);  //establezco conexión con objeto PDO 
                $miDB ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  //y siempre lanzo excepción utilizando manejador propio PDOException cuando se produce un error
                $sqlUsuario = <<<EOD
                                   SELECT * FROM T01_Usuario WHERE 
                                   T01_CodUsuario='{$usuario}';
                                 EOD;
                $consultaUsuario = $miDB -> prepare($sqlUsuario);  //Con consulta preparada, preparo la consulta
                $consultaUsuario ->execute();
                $consulta = $consultaUsuario ->fetchObject();
                    $codUsuario = $consulta -> T01_CodUsuario;
                    $descUsuario = $consulta -> T01_DescUsuario;
                    $numConexiones = $consulta -> T01_NumConexiones;
                    $fechaHoraUltimaConexion = $consulta -> T01_FechaHoraUltimaConexion;
                        $ultimaConexion = new DateTime();
                        $ultimaConexionFormat = $ultimaConexion-> setTimestamp($fechaHoraUltimaConexion) -> format ('d-m-Y H:i:s');
                    $perfil = $consulta -> T01_Perfil;
            }
            catch (PDOException $excepcion){  //codigo si se produce error utilizando PDOException
                echo "<p>Error: ".$excepcion->getCode()."</p>";  //getCode() nos devuelve el codigo del error que salte
                echo "<p style='color: red'>Código del error: ".$excepcion->getMessage()."</p>";  //getMessage() nos devuelve el mensaje que genera el error que saltó
            }
            finally {  
                unset($miDB);  //finalizamos conexion con database
            }
        
            
        /* Si pulsamos el boton BORRAR */
            if (isset($_REQUEST['borrar'])){
                /* ESTABLEZCO CONEXIÓN a la base de datos y lo ELIMINO */
                    try {                                           //Conexión: establezco la conexión y el código que quiero realizar
                        $conexion = new PDO (HOST, USER, PASSWORD); // Establezco la CONEXIÓN a la base de datos con los parametros de la conexión  
                        $conexion ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  //Tratamiento de errores de la clase PDO, con los atributos ATTR_ERRMODE y ERRMODE_EXCEPTION
                        $sqlUpdateDesc = <<<EOD
                                            DELETE FROM T01_Usuario 
                                            WHERE T01_CodUsuario='{$usuario}';
                                          EOD;
                        $consultaUsuario = $conexion -> prepare($sqlUpdateDesc);  //Con consulta preparada, preparo la consulta
                        $consultaUsuario ->execute();

                        /* REDIRIJO AL FICHERO programa.php */
                        header('Location: login.php');  //redirige a la fichero programa.php
                        exit;
                        }  
                        catch (PDOException $error){  //Excepcion: si se producen errores los gestionamos con PDOException
                            echo "<p>Error".$error->getMessage()."</p>";
                            echo "<p>Código del error".$error->getCode()."</p>";
                        }  
                        finally {  //Desconexión: siempre se finaliza la conexión a la base de datos
                            unset($conexion);
                        }

            }
            
        
        /* Si pulsamos el boton ACEPTAR */
        /* VARIABLES para el formulario: */
            $entradaOK = true;  //Variable que indica que todo va bien
            //Constantes para la libreria de validacion
            define('OBLIGATORIO', 1);
            define('OPCIONAL', 0);

        /* ARRAY DE ERRORES Y ENTRADAS DEL FORMULARIO*/
            $aErrores = array(     //Array para guardar los errores del formulario
                'descripcion' => null   //E inicializo cada elemento
                );
            $aRespuestas = array(     //Array para guardar las entradas del formulario correctas
                'descripcion' => null   //E inicializo cada elemento
                );

        /* VALIDACIÓN de cada entrada del formulario con la libreria de validación que importamos
         * y VALIDACIÓN con la base de datos de que usuario y contraseña es correcta */
            if (isset($_REQUEST['aceptar'])){  //Si se ha pulsado el boton enviar
                //Valido cada campo y si hay algun error lo guardo en el array aErrores
                    $aErrores['descripcion']= validacionFormularios::comprobarAlfabetico($_REQUEST['descripcion'], 50, 1, OBLIGATORIO);
                        if ($aErrores['descripcion']!=null){ //si es distinto de null
                            $entradaOK = false;              //si hay algun error entradaOK es false
                        }
            }
            else{  //aun no se ha pulsado el boton enviar
                $entradaOK = false;   // si no se pulsa enviar, entradaOK es false
            }

        /* FORMULARIO Y RESULTADO una vez enviado y con entradas correctas*/
            if($entradaOK){  //Si todas las entradas son correctas
                    $aRespuestas['descripcion']= $_REQUEST['descripcion'];

                /* ESTABLEZCO CONEXIÓN Y MODIFICO la DESCRIPCION del Usuario */
                    try {                                           //Conexión: establezco la conexión y el código que quiero realizar
                        $conexion = new PDO (HOST, USER, PASSWORD); // Establezco la CONEXIÓN a la base de datos con los parametros de la conexión  
                        $conexion ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  //Tratamiento de errores de la clase PDO, con los atributos ATTR_ERRMODE y ERRMODE_EXCEPTION
                        $sqlUpdateDesc = <<<EOD
                                            UPDATE T01_Usuario SET 
                                            T01_DescUsuario = "{$aRespuestas['descripcion']}"  
                                            WHERE T01_CodUsuario='{$usuario}';
                                          EOD;
                        $consultaUsuario = $conexion -> prepare($sqlUpdateDesc);  //Con consulta preparada, preparo la consulta
                        $consultaUsuario ->execute();

                        /* REDIRIJO AL FICHERO programa.php */
                        header('Location: programa.php');  //redirige a la fichero programa.php
                        exit;
                        }  
                        catch (PDOException $error){  //Excepcion: si se producen errores los gestionamos con PDOException
                            echo "<p>Error".$error->getMessage()."</p>";
                            echo "<p>Código del error".$error->getCode()."</p>";
                        }  
                        finally {  //Desconexión: siempre se finaliza la conexión a la base de datos
                            unset($conexion);
                        }

            }

            else{//Si las respuestas no son correctas o aun no se ha pulsado enviar      
                /* MUESTRO EL FORMULARIO */                
            ?>
                <!DOCTYPE html>

                    <html lang="es">
                        <head>
                            <meta charset="utf-8">
                            <title>Sonia Anton Llanes - Tema 5: Proyecto LoginLogout - Login</title>
                            <meta name="author" content="Sonia Antón Llanes">
                            <meta name="description" content="Proyecto DAW2">
                            <meta name="keywords" content="">
                            <link href="../webroot/css/estiloej.css" rel="stylesheet" type="text/css">
                            <link href="../webroot/images/mariposa_vintage.png" rel="icon" type="image/png">
                            <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
                            <link href="https://fonts.googleapis.com/css2?family=Secular+One&display=swap" rel="stylesheet">
                            <style>
                                table{width: 50%;
                                      margin: 20px auto;}
                                .login{width: 50%;
                                       text-align: center;
                                       border: 1px solid black;
                                       margin-top: 50px;
                                       padding: 30px;}
                                th{border: none;}
                                .td{width: 25%;
                                    height: 60px;
                                    border: 1px solid gray;
                                    padding: 2px 10px;}
                                div{width: 90%;
                                    margin: 8px;}
                                .dato{width: 100%;
                                      height: 15px;
                                      font-size: 18px;
                                      text-align: left;}
                                .datoUsu>input{width: 90%;
                                               height: 30px;
                                               font-size: 20px;
                                               border: none;
                                               border-bottom: 1px solid black;
                                               padding: 0 10px;
                                               background: #FADBD8;}
                                .error{width: 90%;
                                       height: 12px;
                                       font-size: 15px;
                                       text-align: right;}
                                #aceptar, #cancelar, #borrar{width: 85%;
                                                             border: 2px solid #BF2411;
                                                             background: #ecaaa1;
                                                             margin: 5px;
                                                             padding: 5px ;
                                                             font-size: 1.5vw;}
                                .vacio{height: 20px;}
                                .ast{color: #bb1212;}
                            </style>
                        </head>
                        <body class="container">
                            <main class="main">
                                <div class="divh2">
                                    <h2 class="centrado"><a href="../../proyectoDWES/indexProyectoDWES.php" style="border-bottom: 2px solid black; color:black;">DWES</a> -
                                    Proyecto Login Logout Tema 5</h2>
                                </div>

                                <div class="div">
                                    <form name="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <table class="login">
                                            <tr>
                                                <th colspan="3"><h3>Editar Perfil Usuario</h3></th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="dato"><label for="LbUsuario">Usuario </label></div>
                                                </td>
                                                <td colspan="2">
                                                    <div class="datoUsu"><input type="text" name="usuario" id="LbUsuario"
                                                        placeholder="<?php echo $codUsuario; ?>" disabled></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="dato"><label for="LbDescripcion">Nombre y Apellidos <span class="ast">*</span></label></div>
                                                </td>
                                                <td colspan="2">
                                                    <div class="datoUsu"><input type="text" name="descripcion" id="LbDescripcion"
                                                        placeholder="<?php echo $descUsuario; ?>" style="background: white;"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <div class="error"><?php
                                                        if ($aErrores['descripcion'] != NULL) { //si hay errores muestra el mensaje
                                                            echo "<span style=\"color:red;\">Campo obligatorio. Solo admite letras, máximo 50 caracteres</span>"; //aparece el mensaje de error que tiene el array aErrores
                                                        }
                                                     ?></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="dato"><label for="LbNumConexiones">Nº de Conexiones </label></div>
                                                </td>
                                                <td colspan="2">
                                                    <div class="datoUsu"><input type="text" name="numConexiones" id="LbNumConexiones"
                                                        placeholder="<?php echo $numConexiones; ?>" disabled></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="dato"><label for="LbUltConexion">Fecha Ultima Conexión </label></div>
                                                </td>
                                                <td colspan="2">
                                                    <div class="datoUsu"><input type="text" name="ultConexion" id="LbUltConexion"
                                                        placeholder="<?php echo $ultimaConexionFormat; ?>" disabled></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="dato"><label for="LbPerfil">Perfil </label></div>
                                                </td>
                                                <td  colspan="2">
                                                    <div class="datoUsu"><input type="text" name="perfil" id="LbPerfil"
                                                        placeholder="<?php echo $perfil; ?>" disabled=></div>
                                                </td>
                                            </tr>
<!--                                            <tr>
                                                <td colspan="2">
                                                    <div class="error"><?php
                                                            if ($aErrores['usuario']!=NULL || $aErrores['password']!=NULL) { //si hay errores muestra el mensaje
                                                                echo "<span style=\"color:red;\">usuario y/o contraseña incorrecto</span>"; //aparece el mensaje de error que tiene el array aErrores
                                                            }
                                                         ?></div>
                                                </td>
                                            </tr>-->
                                            <tr><td class="vacio"></td></tr>
                                            <tr class="buttonForm">
                                                <th><input id="aceptar" name="aceptar" type="submit" value="Guardar Cambios"></th>
                                                <th><input id="borrar" name="borrar" type="submit" value="Eliminar Usuario"></th>
                                                <th><input id="cancelar" name="cancelar" type="submit" value="Cancelar"></th>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                            </main>
                            <footer class="footer">
                                <nav class="fnav">
                                    <ul>
                                        <li class="ftexto"><a href="../../index.html">&copy 2020-21. Sonia Anton LLanes</a></li>
                                        <li>

                                            <a class="maxMedia" href="doc/curriculum_SALL.pdf" target="_blank"><img src="../webroot/images/CV.png" alt="imagen_CV"></a>
                                            <a class="maxMedia" href=""><img src="../webroot/images/linkedin.png" alt="imagen_linkedIn"></a>
                                            <a class="maxMedia" href="https://github.com/SoniaALLSauces" target="_blank"><img src="../webroot/images/github.png" alt="imagen_github"></a>
                                        </li>
                                    </ul>
                                </nav>
                            </footer>   
                        </body>
                    </html>

            <?php
            }
            ?>

