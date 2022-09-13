<?php

require_once '../conexao.php';

session_start();

//verificando se o usuario esta logado
if(!isset($_SESSION['logado'])):
    header("location: ../login_novo.php");
endif;

if(isset($_POST['excluir'])):

    $produtos_id = mysqli_escape_string($conexao, $_POST['produtos_id']);
      
        $sql = "DELETE FROM produtos WHERE produtos_id = '$produtos_id'";
      
        if(mysqli_query($conexao,$sql)):
            header('location: criacao.php?Deletado com sucesso');
        else:
            header('location: criacao.php?erro ao deletar');
        endif;
      
endif;

?>


