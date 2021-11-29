<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Sonia Anton Llanes - Ejercicio 00</title>
        <meta name="author" content="Sonia Antón Llanes">
        <meta name="description" content="Proyecto DAW2">
        <meta name="keywords" content="">
        <link href="webroot/css/estiloej.css" rel="stylesheet" type="text/css">
        <link href="../webroot/images/mariposa_vintage.png" rel="icon" type="image/png">
        <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Secular+One&display=swap" rel="stylesheet">
        <style>
            .table{width: 50%;
                  margin: auto;
                  margin-top: 50px;
                  text-align: center;}
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
            #submit, #value{border: 1px solid black;
                            width: 50%;
                            margin: 20px;
                            padding: 5px;
                            font-size: 1.1rem;}
            .ast{color: #bb1212;}
        </style>
    </head>
    <body class="container">
        
        <main class="main">
        
            <h2 class="centrado"><a href="../219DWESProyectoTema5/indexProyectoTema5.php" style="border-bottom: 2px solid black">TEMA 5:</a>
            Desarrollo de Aplicaciones Web utilizando Código Embebido</h2>
            <h2 class="centrado" style="color:black">Proyecto Login Logout Tema 5</h2>
        
        
            <div>

                <?php

                /* 
                 * Author: Sonia Antón Llanes
                 * Created on: 09-noviembre-2021
                 * Ejercicio 2. Mostrar el contenido de la tabla Departamento y el número de registros.
                 */

                    /* Importamos archivos necesarios */
                        require_once 'config/confDBPDO.php';  //archivo que contiene los parametros de la conexion
                        require_once 'core/libreriaValidacion.php'; //libreria Validación para errores

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

                    /* FORMULARIO */
                        /* VALIDACIÓN de cada entrada del formulario con la libreria de validación que importamos */
                            if (isset($_POST['submit'])){  //Pulso el boton enviar
                                //Valido cada campo y si hay algun error lo guardo en el array aErrores
                                    $aErrores['usuario']= validacionFormularios::comprobarAlfabetico($_REQUEST['usuario'], 50, 1, OBLIGATORIO);
                                    $aErrores['password']= validacionFormularios::comprobarAlfabetico($_REQUEST['password'], 50, 1, OBLIGATORIO);
                                //Recorro array errores y compruebo si se ha incluido algún error
                                foreach ($aErrores as $campo => $error){  
                                    if ($error!=null){         //si es distinto de null
                                        $entradaOK = false;    //si hay algun error entradaOK es false
                                    }
                                }
                            }
                            else{  //aun no se ha pulsado el boton enviar
                                $entradaOK = false;   // si no se pulsa enviar, entradaOK es false
                            }

                        /* FORMULARIO Y RESULTADO una vez enviado y con entradas correctas*/
                            if($entradaOK){  //Si todas las entradas son correctas
                                /* GUARDO EN EL ARRAY $aRespuestas LOS DATOS INTRODUCIDOS EN EL FORMULARIO */
                                    $aRespuestas['usuario']= $_POST['usuario'];
                                    $aRespuestas['password']= $_POST['password'];

                                echo "<h3>HOLA ".$aRespuestas['usuario']."</h3>";
                                echo "<p>Su usuario y contraseña se han introducido correctamente </p>";
                                echo "<button><a href='indexProyectoLoginLogoutTema5.php'>Salir</a></button>";

                            }
                            else{//Si las respuestas no son correctas o aun no se ha pulsado enviar      
                ?>
                                <form name="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                    <table class="table">
                                        <tr>
                                            <th colspan="2"><h3>Formulario LogIN</h3></th>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="td">
                                                <div class="dato"><label for="LbUsuario">Usuario <span class="ast">*</span></label></div>
                                                <div class="datoUsu"><input type="text" name="usuario" id="LbUsuario"
                                                       placeholder="introducir usuario"></div>
                                                <div class="error"><?php
                                                        if ($aErrores['usuario'] != NULL) { //si hay errores muestra el mensaje
                                                            echo "<span style=\"color:red;\">".$aErrores['usuario']."</span>"; //aparece el mensaje de error que tiene el array aErrores
                                                        }
                                                     ?></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="td">
                                                <div class="dato"><label for="LbPassword">Contraseña  <span class="ast">*</span></label></div>
                                                <div class="datoUsu"><input type="text" name="password" id="LbPassword"
                                                       placeholder="introducir contraseña"></div>
                                                <div class="error"><?php
                                                        if ($aErrores['password'] != NULL) { //si hay errores muestra el mensaje
                                                            echo "<span style=\"color:red;\">".$aErrores['password']."</span>"; //aparece el mensaje de error que tiene el array aErrores
                                                        }
                                                     ?></div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th><input id="submit" name="submit" type="submit" value="Iniciar"></th>
                                            <th><input id="value" name="reset" type="reset" value="Cancelar"></th>
                                        </tr>
                                    </table>
                                </form>
                            <?php
                            }
                            ?>    

            </div>
        </main>
        
        
    </body>
</html>