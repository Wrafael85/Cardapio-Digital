<?php
require_once '../conexao.php';
session_start();

//verificando se o usuario esta logado
if(!isset($_SESSION['logado'])):
    header("location: ../login_novo.php");
endif;


//pegar o produto pelo id
if(isset($_GET['produtos_id'])):
    $id = mysqli_escape_string($conexao, $_GET['produtos_id']);

    $sql = "SELECT * FROM produtos WHERE produtos_id = '$id'";
    $resultado = mysqli_query($conexao,$sql);
    $dados = mysqli_fetch_array($resultado);
endif;

if(isset($_POST['salvar'])):
    $nome = mysqli_escape_string($conexao, $_POST['produto']);
    $ingredientes = mysqli_escape_string($conexao, $_POST['ingredientes']);
    $embalagem = mysqli_escape_string($conexao, $_POST['embalagem']);
    $valor = mysqli_escape_string($conexao, $_POST['valor']);
    $produtos_id = mysqli_escape_string($conexao, $_POST['produtos_id']);
      
    $sql = "UPDATE produtos SET nome = '$nome', ingredientes = '$ingredientes', embalagem = '$embalagem',  valor = '$valor' WHERE produtos_id = '$produtos_id'";
      
    if(mysqli_query($conexao,$sql)):
        header('location: criacao.php?Atualizado com sucesso');
    else:
        header('location: criacao.php?erro ao atualizar');
    endif;  

endif;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Editar Produto</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>


    <div class="row">
        <div class="col s12 m6 push-m3">
            <h4 class="light" style="text-align: center;"><b>Editar Produto</h4></b>
            <br>
            <form action="edicao.php" method="POST">                
                <input type="hidden" name="produtos_id" value="<?php echo $dados['produtos_id']; ?>">

                <div class="input-field col s12">
                    <input type="text" name="produto" id="produto" value="<?php echo $dados['nome']; ?>">
                    <label for="produto">Produto</label>
                </div>

                <div class="input-field col s12">
                    <input type="text" name="ingredientes" id="ingredientes"
                        value="<?php echo $dados['ingredientes']; ?>">
                    <label for="ingredientes">Ingredientes</label>
                </div>

                <div class="input-field col s12">
                    <input type="text" name="embalagem" id="embalagem"
                        value="<?php echo $dados['embalagem']; ?>">
                    <label for="embalagem">Embalagem</label>
                </div>

                <div class="input-field col s12">
                    <input type="text" name="valor" id="valor" value="<?php echo $dados['valor']; ?>">
                    <label for="valor">Valor</label>
                </div>
                <p align="center">
                    <button type="submit" name="salvar" class="btn green">Salvar</button>
                </p>
            </form>
        </div>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>

</html>