<?php
//session_start();
require_once '../conexao.php'; 

include_once 'mensage.php';

//verificando se o usuario esta logado
if(!isset($_SESSION['logado'])):
    header("location: ../login_novo.php");
endif;

/// pegando todos os dados do usuario
$id = $_SESSION['usuario_id'];

$sql = "SELECT * FROM usuarios WHERE usuario_id = '$id'";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_array($resultado);


if(isset($_POST['salvar'])):
    $categoria = 'comida';
    $nome = mysqli_escape_string($conexao, $_POST['nome']);
    $ingredientes = mysqli_escape_string($conexao, $_POST['ingredientes']);
    $valor = mysqli_escape_string($conexao, $_POST['valor']);  

    $sql = "INSERT INTO produtos (nome,categoria, ingredientes, valor, usuario_id_fk) VALUES ('$nome','$categoria', '$ingredientes', '$valor', '$id')";
    
    if(empty($nome) or empty($valor)):
      echo "<h6 align='center'><b>"."Atenção! Pelo menos os campos [nome do produto] e [valor] devem ser preenchidos!"."</h6></b>";
      else:
        if(mysqli_query($conexao, $sql)):
            $_SESSION['mensagem'] = "Produto Cadastrado!";
            header('location: novo_produto.php');
        else:
            $_SESSION['mensagem'] = "Erro!";
            header('location: novo_produto.php');
        endif;
  endif; 
endif;
mysqli_close($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Novo Produto / Comidas</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <style>
      button{
        margin: 20px;
      }
    </style>

</head>

<body>

    <div class="row">
        <div class="col s12 m6 push-m3">
            <h4 class="light" style="text-align: center;"><b>Adicionar Novo Produto / Comidas</h4></b>
            <br>
            <form action="novo_produto.php" method="POST">
            
                <div class="input-field col s12">
                    <input type="text" name="nome" id="nome">
                    <label for="nome">Nome do Produto</label>
                </div>

                <div class="input-field col s12">
                    <input type="text" name="ingredientes" id="ingredientes">
                    <label for="ingredientes">Ingredientes</label>
                </div>

                <div class="input-field col s12">
                    <input type="text" name="valor" id="valor">
                    <label for="valor">Valor</label>
                </div>
                <!--botões salvar e visualizar-->
                <p align="center">
                    <!-- usado com a funcaoClicar() <button type="submit" name="salvar" class="btn" onclick="funcaoClicar()">Salvar</button>-->
                    <button type="submit" name="salvar" class="btn green"> Salvar Produto </button>
                    <a href="criacao.php?usuario_id_fk=<?php echo $id; ?>" target="_blank" type="submit" class="btn cyan">Visualizar Cardápio</a>                    
                </p>
            </form>
        </div>
    </div>

    <!-- Modal Structure janela de alerta de exluir produto-->
    <div id="modal<?php echo $dados['nome']; ?>" class="modal">

        <div class="modal-content">
            <h4>Atencão</h4>
            <p>Tem certeza que dejesa excluir este produto?</p>
            <?php echo $dados['nome'];?>
        </div>

        <div class="modal-footer">
            <form action="novo_produto.php" method="POST">

                <button type="submit" name="salvar" class="btn red">Sim, quero deletar!</button>
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
            </form>
        </div>
    </div>

    <!--JavaScript at end of body for optimized loading - otimizar a página onload-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</body>

</html>