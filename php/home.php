<?php
//conexao
require_once "conexao.php";

//inicindo sessão
session_start();

//verificando se o usuario esta logado
if(!isset($_SESSION['logado'])):
    header("location: login_novo.php");
endif;

/// pegando todos os dados do usuario
$id = $_SESSION['usuario_id'];

$sql = "SELECT * FROM usuarios WHERE usuario_id = '$id'";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_array($resultado);
mysqli_close($conexao);
?>


<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<title>Home</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="css/main.css" />
		<noscript><link rel="stylesheet" href="css/noscript.css" /></noscript>

		<style>
			span{
				color: white;
				letter-spacing: 2px;
			}

			
		</style>
	</head>
	<body class="is-preload">
		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<div class="inner" style="background-color: #42426F;">

							<!-- Logo -->
								<a href="#" class="logo">
									<span class="symbol"><img src="img/logo2.png" alt="" /></span><span class="title">Olá, <?php echo $dados['nome'];?></span>
									
								</a>
								<a href="./sair.php" class="logo">
									
									<span class="symbol"></span><button style="background-color: chocolate; border-radius: 8px;">Sair</button></span>
									
								</a>

							<!-- Nav -->
								<!--<nav>
									<ul>
										<li><a href="#menu">Menu</a></li>
									</ul>
								</nav>-->

						</div>
					</header>

				<!-- Menu -->
					<!--<nav id="menu">
						<h2>Opções</h2>
						<ul>
							<li><a href="#"> Sair </a></li>
							
						</ul>
					</nav>-->
			
				<!-- Main -->
					<div id="main">
						<div class="inner">
							<section class="tiles">
								<article class="style1">
									<span class="image">
										<img src="img/comida.jpg" alt="" />
									</span>
									<a href="cardapio/novo_produto.php" target="_blank">
										<h2>Adicionar Comida</h2>
									</a>
								</article>
								<article class="style2">
									<span class="image">
										<img src="img/bebida.jpg" alt="" />
									</span>
									<a href="cardapio/novo_produto_bebidas.php" target="_blank">
										<h2>Adicionar Bebida</h2>
									</a>
								</article>
								<article class="style3">
									<span class="image">
										<img src="img/cardapio.jpg" alt="" />
									</span>
									<a href="cardapio/criacao.php" target="_blank">
										<h2>Editar Cardápio</h2>
									</a>
								</article>
								<article class="style4">
									<span class="image">
										<img src="img/cardapio.jpg" alt="" />
									</span>
									<a href="cardapio/cardapio.php?usuario_id_fk=<?php echo $id; ?>" target="_blank">
										<h2>Visualizar Cardápio</h2>
									</a>
								</article>
								
								<article class="style6">
									<span class="image">
										<img src="img/qrcode.jpg" alt="" />
									</span>
									<a href="cardapio/qrcode.php?imprimir" target="_blank">
										<h2>Imprimir QRcode</h2>
									</a>
                                    
								</article>

			</div>

		<!-- Scripts -->
			<script src="js/jquery.min.js"></script>
			<script src="js/browser.min.js"></script>
			<script src="js/breakpoints.min.js"></script>
			<script src="js/util.js"></script>
			<script src="js/main.js"></script>

	</body>
</html>