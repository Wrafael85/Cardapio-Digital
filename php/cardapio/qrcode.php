<?php

require_once '../conexao.php';


session_start();

//verificando se o usuario esta logado
if(!isset($_SESSION['logado'])):
    header("location: ../login_novo.php");
endif;

/// pegando todos os dados do usuario
$id = $_SESSION['usuario_id'];

$sql = "SELECT * FROM qrcode WHERE usuario_id_fk = '$id'";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_array($resultado);

?>
<?php

if(isset($_GET['imprimir'])):
    echo "<script type='text/javascript'>
    window.onload = function() { window.print(); };
    </script>";
endif;


?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code</title>

    <style>
        hr{
            height: 5px;
        }

        h1{
            text-align: center;
            color: blue;
        }
    </style>
    </head>
<body>
    
<div style="position: absolute; top: 50%;left: 50%; transform: translate(-50%,-50%);" >
<?php 



if(empty($dados)):
    echo "<h1>Você ainda não criou o seu cardápio </h1>";
else:
    echo "<hr>";
    echo $dados['link'];
    echo "<hr>";
    echo "<h1> Escanei o QR code e acesse <br> nosso cardápio </h1>";

endif;
?>

</div>
    
</body>

</html>