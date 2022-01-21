<?php
    // dados para conexão
    $servidor = 'localhost';    // servidor
    $usuario = 'root';          // usuário
    $senhabd = '1lovemyc4t!';              // senha
    $banco = 'sorveteria';       // database

    // conexão com o banco
    $connect = mysqli_connect($servidor, $usuario, $senhabd) or die("Erro na seleção do banco.");

    /* para testar se o banco está conectando
    
        $connect = mysqli_connect($servidor, $usuario, $senhabd);
        
        if(!$connect){
            die('Não conectou! - '. mysql_error());
        }
        echo 'Conectou!';
    */
?>