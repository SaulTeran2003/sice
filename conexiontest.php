<?php
    
   
    function Conectarse()
    {
        include('BDuser.php');
        $dsn = "Driver={SQL Server};Server={$_ENV['DB_HOST']};Database={$_ENV['DB_NAME']};"; //Variables de entorno

        if(!($link = odbc_connect($dsn,$_ENV['DB_USERNAME'],$_ENV['DB_PASSWORD'])))
        {
            echo"Error conectando a la base de datos. ";
            
        }   
        else{
            echo"Base de datos conectada";
            
        }
        return $link;
    }


    $link2 = Conectarse();
?>
