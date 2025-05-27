<?php

    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "agenda_facil";
    $port = 3306; 

    try{
       $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
        //echo "Conex達o com banco de dados realizados com sucesso!";
    }catch(PDOException $err){
        //echo "Erro: Conex達o com o banco de dados n達o realizado!" . $err->getMessage();
    }

?>