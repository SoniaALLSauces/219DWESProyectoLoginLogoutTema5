<!DOCTYPE html>

<!-- Author: Sonia Antón Llanes -->
<!-- Created on: 30-noviembre-2021 -->
<!-- Programa.php Proyecto Login Logout Tema 5 -->

<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Sonia Anton Llanes - programa Login Logout Tema 5</title>
        <meta name="author" content="Sonia Antón Llanes">
        <meta name="description" content="Proyecto DAW2">
        <meta name="keywords" content="">
        <link href="../webroot/css/newcss.css" rel="stylesheet" type="text/css">
        <link href="webroot/images/mariposa_vintage.png" rel="icon" type="image/png">	
        <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@500&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Secular+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">
        <style>
            .datos{margin: 20px;}
            .botones{position: relative;
                     margin-right: 10px;}
            button{width: 100px;
                   height: 50px;}
        </style>
    </head>
    <body class="container">
	<header class="header">
            <h1 class="h1"><a href="../../index.html" style="color: white">Desarrollo de Aplicaciones Web</a></h1>
	</header>
	<main class="main">
            <section class="botones">
                <button><a href="detalle.php">Detalle</a></button>
                <button><a href='../indexProyectoLoginLogoutTema5.php'>Log Out</a></button>
            </section>
            
            <section>
                <h2 class="centrado"><a href="../../219DWESProyectoTema5/indexProyectoTema5.php" style="border-bottom: 2px solid black">TEMA 5:</a>
                Desarrollo de Aplicaciones Web utilizando Código Embebido</h2>
                <h2 class="centrado" style="color:black">Proyecto Login Logout Tema 5</h2>         
            </section>
            
            <section class="datos">
                
                <?php

                /* 
                 * Author: Sonia Antón Llanes
                 * Created on: 30-noviembre-2021
                 * Ejercicio: ventana que se muestra cuando el login es correcto
                 */
                
                /*Variables que necesito para el saludo*/
                    $usuario= $_SESSION['Usuario'];
                    $fechaHoraUltimaConexion = $_SESSION['FechaHolaUltimaConexion'];
                
                /* Importamos archivos necesarios */
                        require_once '../config/confDBPDO.php';  //archivo que contiene los parametros de la conexion
                    
                        try{
                            $miDB = new PDO (HOST, USER, PASSWORD);  //establezco conexión con objeto PDO 
                            $miDB ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  //y siempre lanzo excepción utilizando manejador propio PDOException cuando se produce un error
                            //$codigoDepartamento= $_REQUEST['codDepartamento'];  //variable donde guardo el valor codigo del formulario
                            $sqlUsuario = <<<EOD
                                               SELECT T01_DescUsuario FROM T01_Usuario WHERE 
                                               T01_CodUsuario={$usuario};
                                             EOD;
                            $consultaUsuario = $miDB -> prepare($sqlUsuario);  //Con consulta preparada, preparo la consulta
                            $consultaUsuario ->execute();
                        
                        }
                        catch (PDOException $excepcion){  //codigo si se produce error utilizando PDOException
                            echo "<p>Error: ".$excepcion->getCode()."</p>";  //getCode() nos devuelve el codigo del error que salte
                            echo "<p style='color: red'>Código del error: ".$excepcion->getMessage()."</p>";  //getMessage() nos devuelve el mensaje que genera el error que saltó
                        }
                        finally {  
                            unset($miDB);  //finalizamos conexion con database
                        }
                
                    echo "<h3>HOLA $consultaUsuario</h3>";
                    echo "<p>Su usuario y contraseña se han introducido correctamente </p>";
                
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