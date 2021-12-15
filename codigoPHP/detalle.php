<?php

    /* 
     * Author: Sonia Antón Llanes
     * Created on: 29-noviembre-2021
     * LOGIN: ventana para iniciar sesion de un usuario guardado en una tabla 'usuarios' de la base de datos
     */

        /* Inicio la Sesion */
            session_start();

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
            .h2{color: #bb1212;
                font-family: 'Dancing Script', cursive;
                font-size: 32px;
                font-weight: bolder;}
            .tableVariable{width: 80vw;}
            .tableVariable>td{height: 10px;}
            .login{width: 50%;
                   text-align: center;
                   border: 1px solid black;
                   margin-top: 50px;
                   padding: 30px;}
            th{border: none;}
            .td{border: 1px solid gray;
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
            .button{width: 100%;}
            .ast{color: #bb1212;}
        </style>
    </head>
    <body class="container">
        <main class="main" style="background:white;">
            <div class="divh2">
                <a class="volver" href="../indexProyectoLoginLogoutTema5.php">
                    <img src="../webroot/images/volver.png">
                </a>
                <h2 class="centrado"><a href="../../proyectoDWES/indexProyectoDWES.php" style="border-bottom: 2px solid black; color:black;">DWES</a> -
                Proyecto Login Logout Tema 5</h2>
            </div>

            <div>
                    <!-- $_SESSION -->
                <table class="tableVariable">
                    <tr>
                        <td class="nombreVariable"><h4>Variable $_SESSION</h4></td>
                    </tr>
                </table>
                <table class="tableVariable">
                    <?php
                        foreach ($_SESSION as $elemento => $valor) {
                            echo "<tr>";
                            print_r("<td class=\"td\">$elemento</td> <td class=\"td\">$valor</td>");
                            echo "</tr>";
                        }
                    ?>
                </table>

                    <!-- $_SERVER -->
                <table class="tableVariable">
                    <tr>
                        <td class="nombreVariable"><h4>Variable $_SERVER</h4></td>
                    </tr>
                </table>
                <table class="tableVariable">
                    <?php
                        foreach ($_SERVER as $elemento => $valor) {
                            echo "<tr>";
                            print_r("<td class=\"td\">$elemento</td> <td class=\"td\">$valor</td>");
                            echo "</tr>";
                        }
                echo "</table>";        
                    ?>
                
                    
                <table class="tableVariable">
                    <tr>
                        <td class="nombreVariable"><h4>PHPINFO()</h4></td>
                    </tr>
                </table>
                    <?php
                    /* Mostramos phpinfo() */            
                        phpinfo();

                    ?>
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