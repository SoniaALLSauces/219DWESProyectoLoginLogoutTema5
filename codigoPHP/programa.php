<?php

    /* 
     * Author: Sonia Antón Llanes
     * Created on: 30-noviembre-2021
     * Ejercicio: ventana programa que se muestra cuando el login (usuario y contraseña) es correcto
     */

        /* Importamos archivos necesarios */
            require_once '../config/confDBPDO.php';  //archivo que contiene los parametros de la conexion 

        /* INICIO LA SESION */
            session_start();
        
        /*Variables que necesito para el saludo*/
            $usuario= $_SESSION['UsuarioDAW219AppLoginLogout'];
            $fechaHoraUltimaConexion = $_SESSION['FechaHoraUltimaConexion'];
        
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
            .subrayado{border-bottom: 2px solid #bb1212;
                       padding-bottom: 10px;}
            .botones{position: relative;
                     float: right;
                     right: 10px;}
            button{width: 13vw;
                   height: 60px;
                   border: 2px solid #BF2411;
                   background: #ecaaa1;
                   margin: 5px 10px;
                   padding: 5px 20px;
                   font-size: 1.8vw;
                   vertical-align: middle;}
            div{width: 90%;
                margin: 8px;}
            .saludo{margin: 100px;}
            
        </style>
    </head>
    <body class="container">
        <main class="main">
            <div class="divh2">
                <a class="volver" href="../indexProyectoLoginLogoutTema5.php">
                    <img src="../webroot/images/volver.png">
                </a>
                <h2 class="centrado"><a href="../../proyectoDWES/indexProyectoDWES.php" style="border-bottom: 2px solid black; color:black;">DWES</a> -
                Proyecto Login Logout Tema 5</h2>
            </div>

            <section class="botones">
                <button><a href="editarPerfil.php">Editar Perfil</a></button>
                <button><a href="detalle.php">Detalle</a></button>
                <button><a href='../indexProyectoLoginLogoutTema5.php'>Log Out</a></button>
            </section>
            
            <section class="datos">
                
                <?php

                /* 
                 * Author: Sonia Antón Llanes
                 * Created on: 30-noviembre-2021
                 * Ejercicio: ventana que se muestra cuando el login es correcto
                 */

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
                                $descUsuario = $consulta -> T01_DescUsuario;
                                $numConexiones = $consulta -> T01_NumConexiones;
                            
                            echo "<div class='saludo'>";
                                echo "<h3>HOLA $descUsuario</h3>";
                                if ($numConexiones==1){
                                    echo "<p>Es la PRIMERA vez que se conecta.</p>";
                                } else{
                                    echo "<p>Es la ".$numConexiones."ª vez que se conecta.</p>";
                                    $ultimaConexion = new DateTime();
                                    $ultimaConexionFormat = $ultimaConexion-> setTimestamp($fechaHoraUltimaConexion) -> format ('d-m-Y H:i:s');
                                    echo "<p>Se conectó por ultima vez el: $ultimaConexionFormat </p>";
                                }
                            echo "</div>";
                        }
                        catch (PDOException $excepcion){  //codigo si se produce error utilizando PDOException
                            echo "<p>Error: ".$excepcion->getCode()."</p>";  //getCode() nos devuelve el codigo del error que salte
                            echo "<p style='color: red'>Código del error: ".$excepcion->getMessage()."</p>";  //getMessage() nos devuelve el mensaje que genera el error que saltó
                        }
                        finally {  
                            unset($miDB);  //finalizamos conexion con database
                        }
                
                ?>
                
            </section>
        </main>
        <footer class="footer">
            <nav class="fnav">
                <ul>
                    <li class="ftexto"><a href="indexProyectoDWES.php">&copy 2020-21. Sonia Anton LLanes</a></li>
                    <li>
                        
                        <a class="maxMedia" href="../doc/curriculum_SALL.pdf" target="_blank"><img src="../webroot/images/CV.png" alt="imagen_CV"></a>
                        <a class="maxMedia" href=""><img src="../webroot/images/linkedin.png" alt="imagen_linkedIn"></a>
                        <a class="maxMedia" href="https://github.com/SoniaALLSauces" target="_blank"><img src="../webroot/images/github.png" alt="imagen_github"></a>
                    </li>
                </ul>
            </nav>
        </footer>       
    </body>
</html>