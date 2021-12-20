<?php

    /* 
     * Author: Sonia Antón Llanes
     * Created on: 29-noviembre-2021
     * Last Modify: 16-diciembre-2021
     * INDEX PROYECTO LOGIN LOGOUT: ventana para iniciar cookie idioma e ir a la ventana login
     */

        /* Si NO se ha pulsado ningun idioma por defecto esta seleccionado el ESPAÑOL */
            if (!isset($_COOKIE['idioma'])){                            //si no existe la cookie idioma
                setcookie("idioma",'es', time()+2592000);               //creo la cookie idioma
                header('Location: indexProyectoLoginLogoutTema5.php');  //recargo la pagina en el idioma por defecto
                exit;
            }

        /* Si pulsamos un BOTON de IDIOMA */
            if (isset($_REQUEST['idiomaSeleccionado'])){
                setcookie("idioma", $_REQUEST['idiomaSeleccionado'], time()+2592000);
                header('Location: indexProyectoLoginLogoutTema5.php');  //redirige a la fichero programa.php
                exit;
            }
        
        /* Importamos archivo de idioma */
            require_once 'core/idiomas.php';  //archivo
            
?>


<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Sonia Anton Llanes - index Login Logout Tema 5</title>
        <meta name="author" content="Sonia Antón Llanes">
        <meta name="description" content="Proyecto DAW2">
        <meta name="keywords" content="">
        <link href="webroot/css/estiloej.css" rel="stylesheet" type="text/css">
        <link href="webroot/images/mariposa_vintage.png" rel="icon" type="image/png">	
        <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@500&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Secular+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">
        <style>
            .main{background: white;}
            .button{width: 100%;
                    text-align: center;}
            .button>*{height: 80px;
                      margin: 100px;
                      padding: 20px 50px;
                      border: 2px solid #BF2411;
                      border-radius: 50% 20%;
                      background: #ecaaa1;
                      font-size: 1.5rem;
                      font-family: 'Secular One', sans-serif;
                      font-weight: bolder;}
            .idiomas>form{display: inline-block;
                          position: relative;
                          float: right;
                          right: 10px;}
            form>button{margin: 10px;
                        border: 0;}
        </style>
    </head>
    <body class="container">
	<main class="main">
            <div class="divh2">
                <h2 class="centrado" style="color:black"><a href="../../proyectoDWES/indexProyectoDWES.php" style="border-bottom: 1px solid black;">DWES </a>-
                    Desarrollo de Aplicaciones Web utilizando Código Embebido</h2>
                <h2 class="centrado">Proyecto Login Logout Tema 5</h2> 
            </div>
            
            <section class="idiomas">
                <form name="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <button type="submit" name="idiomaSeleccionado" value="en"><img src="webroot/images/bInglaterra.png" alt="idiomaIngles" width="50px" height="30px"></button>
                    <button type="submit" name="idiomaSeleccionado" value="ar"><img src="webroot/images/bMarruecos.png" alt="idiomaIngles" width="50px" height="30px"></button>
                    <button type="submit" name="idiomaSeleccionado" value="es"><img src="webroot/images/bEspana.png" alt="idiomaIngles" width="50px" height="30px"></button>
                    <button type="submit" name="idiomaSeleccionado" value="ga"><img src="webroot/images/bGalicia.jpg" alt="idiomaIngles" width="50px" height="30px"></button>
                    <button type="submit" name="idiomaSeleccionado" value="ct"><img src="webroot/images/bCataluna.jpg" alt="idiomaIngles" width="50px" height="30px"></button>
                    <button type="submit" name="idiomaSeleccionado" value="va"><img src="webroot/images/bPaisVasco.png" alt="idiomaIngles" width="50px" height="30px"></button>
                </form>
            </section>
            
            <section class="button">
                <button><a href="codigoPHP/login.php"><?php echo $aIdiomas[$_COOKIE['idioma']]['inicio']; ?></a></button>
            </section>
        </main>
        <footer class="footer">
            <nav class="fnav">
                <ul>

                    <li class="ftexto"><a href="../index.html">&copy 2020-21. Sonia Anton LLanes - v.2 - 03/12/2021</a></li>

                    <li>
                        
                        <a class="maxMedia" href="doc/curriculum_SALL.pdf" target="_blank"><img src="webroot/images/CV.png" alt="imagen_CV"></a>
                        <a class="maxMedia" href=""><img src="webroot/images/linkedin.png" alt="imagen_linkedIn"></a>
                        <a class="maxMedia" href="https://github.com/SoniaALLSauces/219DWESProyectoLoginLogoutTema5.git" target="_blank"><img src="webroot/images/github.png" alt="imagen_github"></a>
                    </li>
                </ul>
            </nav>
        </footer>       
    </body>
</html>