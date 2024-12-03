<?php
    $host= 'localhost';
    $usuario = 'root';
    $senha = 'undegor!13';
    $dbname = 'rpavan';

    try{
        $conexao = new PDO("mysql:host=$host;dbname=$dbname",$usuario,$senha);
        $conexao -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        $e ->getMessage();
    }
?>