<?php

    /* 
     * Author: Sonia Antón Llanes
     * Created on: 29-noviembre-2021
     * LOGIN: ventana para iniciar sesion de un usuario guardado en una tabla 'usuarios' de la base de datos
     */

        /* Importamos archivos necesarios */
            require_once '../config/confDBPDO.php';  //archivo que contiene los parametros de la conexion
            require_once '../core/libreriaValidacion.php'; //libreria Validación para errores

        /* VARIABLES: */
            $entradaOK = true;  //Variable que indica que todo va bien
            //Constantes para la libreria de validacion
            define('OBLIGATORIO', 1);
            define('OPCIONAL', 0);

        /* ARRAY DE ERRORES Y ENTRADAS DEL FORMULARIO*/
            $aErrores = array(     //Array para guardar los errores del formulario
                'usuario' => null,   //E inicializo cada elemento
                'password' => null
                );
            $aRespuestas = array(     //Array para guardar las entradas del formulario correctas
                'usuario' => null,   //E inicializo cada elemento
                'password' => null
                );

        /* VALIDACIÓN de cada entrada del formulario con la libreria de validación que importamos
         * y VALIDACIÓN con la base de datos de que usuario y contraseña es correcta */
            if (isset($_REQUEST['login'])){  //Si se ha pulsado el boton enviar
                //Valido cada campo y si hay algun error lo guardo en el array aErrores
                    $aErrores['usuario']= validacionFormularios::comprobarAlfabetico($_REQUEST['usuario'], 8, 1, OBLIGATORIO);
                    $aErrores['password']= validacionFormularios::validarPassword($_REQUEST['password'], 8, 1, 1, OBLIGATORIO);
                
                    foreach ($aErrores as $campo => $error){  //Recorro array errores y compruebo si se ha incluido algún error
                        if ($error!=null){         //si es distinto de null
                            $entradaOK = false;    //si hay algun error entradaOK es false
                        }
                        else {                     //si no hay errores de entrada compruebo que el usuario no exista
                            try{
                                /* GUARDO EN EL ARRAY $aRespuestas LOS DATOS INTRODUCIDOS EN EL FORMULARIO */
                                $aRespuestas['usuario']= $_REQUEST['usuario'];
                                $aRespuestas['password']= $_REQUEST['password'];
                                /* COMPRUEBO CON LA BASE DE DATOS QUE SON CORRECTOS USUARIO Y CONTRASEÑA */
                                $miDB = new PDO (HOST, USER, PASSWORD);  //establezco conexión con objeto PDO 
                                $miDB ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  //y siempre lanzo excepción utilizando manejador propio PDOException cuando se produce un error
                                //$codigoDepartamento= $_REQUEST['codDepartamento'];  //variable donde guardo el valor codigo del formulario
                                $sqlUsuario = <<<EOD
                                                   SELECT * FROM T01_Usuario WHERE 
                                                   T01_CodUsuario=:usuario AND 
                                                   T01_Password=:password;
                                                 EOD;
                                $parametros = array (
                                    ':usuario' => $aRespuestas['usuario'],
                                    ':password' => hash('sha256',($aRespuestas['usuario'].$aRespuestas['password']))
                                );
                                $consultaUsuario = $miDB -> prepare($sqlUsuario);  //Con consulta preparada, preparo la consulta
                                $consultaUsuario ->execute($parametros);
                                $consulta = $consultaUsuario ->fetchObject();
                            //Buscamos en la tabla si algun registro coindice con el usuario-contraseña introducida
                                if ($consultaUsuario->rowCount()==0){  //si no encuentra ningún registro (usuario y contraseña)
                                    $aErrores['usuario']= "usuario no encontrado";
                                    $entradaOK = false;
                                } else{
                                    $codUsuario = $consulta -> T01_CodUsuario;
                                    $fechaHoraUltimaConexion = $consulta -> T01_FechaHoraUltimaConexion;
                                }
                            }
                            catch (PDOException $excepcion){  //codigo si se produce error utilizando PDOException
                                echo "<p>Error: ".$excepcion->getCode()."</p>";  //getCode() nos devuelve el codigo del error que salte
                                echo "<p style='color: red'>Código del error: ".$excepcion->getMessage()."</p>";  //getMessage() nos devuelve el mensaje que genera el error que saltó
                            }
                            finally {  
                                unset($miDB);  //finalizamos conexion con database
                            }
                        }
                    }
            }
            else{  //aun no se ha pulsado el boton enviar
                $entradaOK = false;   // si no se pulsa enviar, entradaOK es false
            }

        /* FORMULARIO Y RESULTADO una vez enviado y con entradas correctas*/
            if($entradaOK){  //Si todas las entradas son correctas
                    $aRespuestas['usuario']= $_REQUEST['usuario'];
                    $aRespuestas['password']= $_REQUEST['password'];

                /* ESTABLEZCO CONEXIÓN Y MODIFICO FECHA DE LA ULTIMA CONEXIÓN Y NUMERO DE CONEXIONES */
                    try {                                           //Conexión: establezco la conexión y el código que quiero realizar
                        $conexion = new PDO (HOST, USER, PASSWORD); // Establezco la CONEXIÓN a la base de datos con los parametros de la conexión  
                        $conexion ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  //Tratamiento de errores de la clase PDO, con los atributos ATTR_ERRMODE y ERRMODE_EXCEPTION

                        //Actualizo los datos: fecha ultima conexion y numero de conexiones del usuario en la tabla
                        $sqlUpdate = <<<EOD
                                          UPDATE T01_Usuario SET 
                                            T01_NumConexiones = T01_NumConexiones+1 ,
                                            T01_FechaHoraUltimaConexion=:ultimaconexion
                                          WHERE T01_CodUsuario=:codUsuario;
                                        EOD;
                        $fechaAhora = new DateTime();
                        $ahora = $fechaAhora->getTimestamp();
                        $parametros = array (
                                ':ultimaconexion' => $ahora,
                                ':codUsuario' => $aRespuestas['usuario']
                            );
                        $consultaUsuario = $conexion -> prepare($sqlUpdate);  //Con consulta preparada, preparo la consulta
                        $consultaUsuario ->execute($parametros);

                        /* INICIO SESION Y GUARDO el usuario y fecha ultima conexion */
                            session_start();   // inicio la sesion
                            $_SESSION['UsuarioDAW219AppLoginLogout']= $codUsuario;   //guardo el usuario logeado
                            $_SESSION['FechaHoraUltimaConexion']= $fechaHoraUltimaConexion;   //guardo la fecha de la ultima conexión con el select antes del update

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
                            <title>Sonia Anton Llanes - Ejercicio 00</title>
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
                                .dato, .error{width: 100%;
                                              height: 15px;
                                              font-size: 18px;}
                                .datoUsu>input{width: 100%;
                                               height: 30px;
                                               font-size: 20px;
                                               border: none;
                                               border-bottom: 1px solid black;
                                               padding: 0 10px;}
                                #login, .volver{width: 50%;
                                                 border: 1px solid black;
                                                 margin: 5px;
                                                 padding: 5px 20px;
                                                 font-size: 1.1rem;
                                                 background: lightgrey;}
                                .ast{color: #bb1212;}
                            </style>
                        </head>
                        <body class="container">

                            <main class="main">

                                <h2 class="centrado"><a href="../../219DWESProyectoTema5/indexProyectoTema5.php" style="border-bottom: 2px solid black">TEMA 5:</a>
                                Desarrollo de Aplicaciones Web utilizando Código Embebido</h2>
                                <h2 class="centrado" style="color:black">Proyecto Login Logout Tema 5</h2>

                                <div>
                                    <form name="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <table class="login">
                                            <tr>
                                                <th><h3>Formulario LogIN</h3></th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="dato"><label for="LbUsuario">Usuario <span class="ast">*</span></label></div>
                                                    <div class="datoUsu"><input type="text" name="usuario" id="LbUsuario"
                                                           placeholder="introducir usuario"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="dato"><label for="LbPassword">Contraseña  <span class="ast">*</span></label></div>
                                                    <div class="datoUsu"><input type="password" name="password" id="LbPassword"
                                                           placeholder="introducir contraseña"></div>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="error"><?php
                                                            if ($aErrores['usuario']!=NULL || $aErrores['password']!=NULL) { //si hay errores muestra el mensaje
                                                                echo "<span style=\"color:red;\">Introduzca usuario y contraseña correctas</span>"; //aparece el mensaje de error que tiene el array aErrores
                                                            }
                                                         ?></div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="iniciar">
                                            <tr>
                                                <th><input id="login" name="login" type="submit" value="Iniciar Sesion"></th>
                                                <th><a class="volver" href="../indexProyectoLoginLogoutTema5.php">Volver</a></th>
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




<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Sonia Anton Llanes - Ejercicio 00</title>
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
            .dato, .error{width: 100%;
                          height: 15px;
                          font-size: 18px;}
            .datoUsu>input{width: 100%;
                           height: 30px;
                           font-size: 20px;
                           border: none;
                           border-bottom: 1px solid black;
                           padding: 0 10px;}
            #login, .volver{width: 50%;
                             border: 1px solid black;
                             margin: 5px;
                             padding: 5px 20px;
                             font-size: 1.1rem;
                             background: lightgrey;}
            .ast{color: #bb1212;}
        </style>
    </head>
    <body class="container">
        
        <main class="main">
        
            <h2 class="centrado"><a href="../../219DWESProyectoTema5/indexProyectoTema5.php" style="border-bottom: 2px solid black">TEMA 5:</a>
            Desarrollo de Aplicaciones Web utilizando Código Embebido</h2>
            <h2 class="centrado" style="color:black">Proyecto Login Logout Tema 5</h2>
        
            <div>
                <form name="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <table class="login">
                        <tr>
                            <th><h3>Formulario LogIN</h3></th>
                        </tr>
                        <tr>
                            <td>
                                <div class="dato"><label for="LbUsuario">Usuario <span class="ast">*</span></label></div>
                                <div class="datoUsu"><input type="text" name="usuario" id="LbUsuario"
                                       placeholder="introducir usuario"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="dato"><label for="LbPassword">Contraseña  <span class="ast">*</span></label></div>
                                <div class="datoUsu"><input type="password" name="password" id="LbPassword"
                                       placeholder="introducir contraseña"></div>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="error"><?php
                                        if ($aErrores['usuario']!=NULL || $aErrores['password']!=NULL) { //si hay errores muestra el mensaje
                                            echo "<span style=\"color:red;\">Introduzca usuario y contraseña correctas</span>"; //aparece el mensaje de error que tiene el array aErrores
                                        }
                                     ?></div>
                            </td>
                        </tr>
                    </table>
                    <table class="iniciar">
                        <tr>
                            <th><input id="login" name="login" type="submit" value="Iniciar Sesion"></th>
                            <th><a class="volver" href="../indexProyectoLoginLogoutTema5.php">Volver</a></th>
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