<?php
require_once '../conexao.php';

if(isset($_GET['usuario_id_fk'])):
    $id = mysqli_escape_string($conexao, $_GET['usuario_id_fk']);

endif;


// pegando a url do cardapio
$protocolo = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
$u = '://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?'.$_SERVER['QUERY_STRING'];

$url = $protocolo.$u;


$link = "<img src=https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl=$url&choe=UTF-8>";

$result = "SELECT usuario_id_fk FROM qrcode WHERE usuario_id_fk = '$id'";
$resultado = mysqli_query($conexao, $result);

if(mysqli_num_rows($resultado) > 0):
    
else:
    $result = "INSERT INTO qrcode(link,usuario_id_fk) VALUES ('$link','$id')";
    $resultado = mysqli_query($conexao, $result);
 
endif;
//pegar a imagem na pasta php/cardapio/arquivos
$sql = "SELECT * FROM arquivos WHERE usuario_id_fk = '$id'";
$resultado = mysqli_query($conexao, $sql);
$imagem = mysqli_fetch_array($resultado);
?>

 


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Cardápio</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <style>
    #logoEmpresa{
        width: 100%;
        height: 350px;
        background-color: white;
    }
    th{
        color: white;
        font-size: 20px;
    }
    td{
        color: white;
    }
    h2{
        color: white;
    }
    </style>
</head>

<body>

<div class="row">
    <div class="col s12 m6 push-m3" style="background-color: black;">
    
    <div class="row">
        <div style="left: 10px;">
        <img src="<?php echo $imagem['path']; ?>" id="logoEmpresa">
        <h2 style="text-align: center;">Cardápio</h2>
            <h4 style="text-align: left; color: white;"><b> Comidas </h4></b>
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Ingredientes</th>
                        <th>Valor</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
            $sql = "SELECT * FROM produtos WHERE categoria = 'comida' and usuario_id_fk = '$id'";
            $resultado = mysqli_query($conexao,$sql);
            while($dados = mysqli_fetch_array($resultado)):
          ?>
                    <tr>
                        <td><?php echo $dados['nome']; ?></td>
                        <td><?php echo $dados['ingredientes']; ?></td>
                        <td><?php echo $dados['valor']; ?></td>
                    </tr>
                    <?php endwhile;?>
                </tbody>
            </table>
        </div>
    </div>
    
        <br>

    <div class="row">
        <div class="">
            <h4 style="text-align: left; color: white;"><b> Bebidas </h4></b>
            <table class="">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Embalagem</th>
                        <th>Valor</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
            $sql = "SELECT * FROM produtos WHERE categoria = 'bebida' and usuario_id_fk = '$id'";
            $resultado = mysqli_query($conexao,$sql);
            while($dados = mysqli_fetch_array($resultado)):
          ?>
                    <tr>
                        <td><?php echo $dados['nome']; ?></td>
                        <td><?php echo $dados['embalagem']; ?></td>
                        <td><?php echo $dados['valor']; ?></td>
                    </tr>
                    <?php endwhile;?>
                </tbody>
            </table>
        </div>
    </div>


    </div>
</div>

    <!--JavaScript at end of body for optimized loading-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>

</html>