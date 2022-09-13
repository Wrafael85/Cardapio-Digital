<?php
    //conexão com o banco de dados
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'cardapio_digital';

    $conexao = mysqli_connect($dbHost, $dbUsername,  $dbPassword, $dbName);

    //verificando se existe algum erro de conexão e exibindo o erro na tela
    if(mysqli_connect_error()):
        echo "Erro na conexão: ".mysqli_connect_error();    
    endif;    
?>

