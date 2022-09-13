<?php
require_once '../conexao.php';

session_start();

//verificando se o usuario esta logado
if(!isset($_SESSION['logado'])):
    header("location: ../login_novo.php");
endif;

/// pegando todos os dados do usuario
$id = $_SESSION['usuario_id'];
?>

<!--envio do arquivo de imagem de fundo-->
<?php 
    if(isset($_FILES['arquivo'])){
        $arquivo = $_FILES['arquivo'];    
        $pasta = "arquivos/";                                                   //seleciona a pasta para inserir o arquivo 
        $nomeDoArquivo = $arquivo['name'];                                      //pega o nome do arquivo    
        $novoNomeDoArquivo = uniqid();                                          //cria um nome único para o arquivo
        $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));   //pega a extensão do arquivo e converte pra minusculo
            
        $path = $pasta . $novoNomeDoArquivo . "." . $extensao;  //variável que recebe o novo nome com a extensão e a pasta do novo arquivo
            
        //variável que vai mover o arquivo com nome criado temporário para a pasta /arquivos
        $deu_certo = move_uploaded_file($arquivo["tmp_name"], $path);                          
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Edição do Cardápio</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
      #button{
        margin: 10px;
      }
    </style>
</head>

<body>

    <div class="row">
        <div class="col s12 m6 push-m3">
            <h4 class="light" style="text-align: center;"><b>Editar / Excluir Produtos</h4></b>
            <table class="striped">
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Produto</th>
                        <th>Ingredientes</th>
                        <th>Embalagem</th>
                        <th>Valor</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $sql = "SELECT * FROM produtos WHERE usuario_id_fk = '$id'";
                        $resultado = mysqli_query($conexao,$sql);
                        while($dados = mysqli_fetch_array($resultado)):
                    ?>
                    <tr>
                        <td><?php echo $dados['categoria']; ?></td>
                        <td><?php echo $dados['nome']; ?></td>
                        <td><?php echo $dados['ingredientes']; ?></td>
                        <td><?php echo $dados['embalagem']; ?></td>
                        <td><?php echo $dados['valor']; ?></td>

                        <!--botões editar/excluir-->
                        <td><a href="edicao.php?produtos_id=<?php echo $dados['produtos_id']; ?>"
                                class="btn-floating orange"><i class="material-icons">edit</i></td>
                        <td><a href="#modal<?php echo $dados['produtos_id']; ?>"
                                class="btn-floating red modal-trigger"><i class="material-icons">delete</i></a></td>

                        <!-- Modal Structure caixa de messagem de alerta-->
                        <div id="modal<?php echo $dados['produtos_id']; ?>" class="modal">

                            <div class="modal-content">
                                <h3 align="center">Atencão!!!</h3>
                                <h4 align="center">Tem certeza que dejesa excluir este produto?</h4>
                                    <br>Produto : <?php echo $dados['nome']; ?>
                                </h5>
                            </div>

                            <div class="modal-footer">
                                <form action="excluir.php" method="POST">
                                    <input type="hidden" name="produtos_id"
                                        value="<?php echo $dados['produtos_id']; ?>">
                                    <button type="submit" name="excluir" class="btn red">Excluir</button>
                                    <a href="#!" class="modal-close btn green">Cancelar</a>
                                </form>
                            </div>
                        </div>
                    </tr>
                    <?php endwhile;?>
                </tbody>
            </table>
            <br>
            <p align="center">
            <a id="button" href="novo_produto.php" target="_blank" type="submit" class="btn green">Adiconar Comidas</a>
            <a id="button" href="novo_produto_bebidas.php" target="_blank" type="submit" class="btn green">Adiconar Bebidas</a>            
            <a id="button" href="cardapio.php?usuario_id_fk=<?php echo $id; ?>" class="btn cyan">Visualizar Cardápio</a>
            </p>
        </div>
    </div>

    <br><br><br>
    
    <!--formulário para inserir imagem de fundo-->
    <form method="POST" enctype="multipart/form-data" action="" style="text-align: center;">
        <hr><h5>
        <p align="center"><label for=""> <h5>Selecione a logomarca de sua empresa para o seu cardápio </h5></label>
            <h5><input name="arquivo" type="file">
            <button name="upload" type="submit"> Enviar arquivo de imagem </button>
            </h5>
        </p>
        <hr></h5>

        <?php
        //mensagem quando for enviado o arquivo de imagem e inserido no banco
        if(!empty($deu_certo)){
                //insere o caminho do arquivo na tabela arquivos na coluna path
                $result = "SELECT usuario_id_fk FROM arquivos WHERE usuario_id_fk = '$id'";
                $resultado = mysqli_query($conexao, $result);

                if(mysqli_num_rows($resultado) > 0):
                    $sql = "UPDATE arquivos SET nome = '$nomeDoArquivo', path = '$path' WHERE usuario_id_fk = '$id'";
                    $insereNoBanco = mysqli_query($conexao, $sql);
                    echo "<p align='center'>Arquivo [".$nomeDoArquivo."] enviado com sucesso! <br> Visualizar arquivo, <a target=\"_blank\" href=\"arquivos/$novoNomeDoArquivo.$extensao\"> clique aqui. </a>";
                    
                else:
                    $sql = "INSERT INTO arquivos(nome, path, usuario_id_fk) VALUES('$nomeDoArquivo', '$path', '$id')";
                    $insereNoBanco = mysqli_query($conexao, $sql);            
                    echo "<p align='center'>Arquivo [".$nomeDoArquivo."] enviado com sucesso! <br> Visualizar arquivo, <a target=\"_blank\" href=\"arquivos/$novoNomeDoArquivo.$extensao\"> clique aqui. </a>";
                
                endif;

            } 
        ?>
    </form>

    <!--JavaScript at end of body for optimized loading-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <!--scrpit para inicializar a janela Modal-->
    <script>
    M.AutoInit();
    </script>

</body>

</html>