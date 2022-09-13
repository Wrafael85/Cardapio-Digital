<?php
    //conexão com o bando de dados
    require_once "conexao.php";

    //iniciando sessão
    session_start();

    //botao login
    if(isset($_POST['button'])):
        $erros = array();
        $email = mysqli_escape_string($conexao, $_POST['email']);
        $senha = mysqli_escape_string($conexao, $_POST['senha']);

        // verificando se os campos estao vazios
        if(empty($email) or empty($senha)):
            $erros[] = "<li> Todos os campos precisam ser preenchidos </li>";
        else:
            // verificando se o email passado já está no banco de dados
            $sql = "SELECT email FROM usuarios WHERE email = '$email'";
            $resultado = mysqli_query($conexao, $sql);

            if(mysqli_num_rows($resultado) > 0):
				$sql = "SELECT * FROM usuarios WHERE email = '$email'";
            	$resultado = mysqli_query($conexao, $sql);
				$dados = mysqli_fetch_array($resultado);
				
				//discriptografando senha
				if(password_verify($senha, $dados['senha'])):
					$nova_senha = $dados['senha'];

					// verificando se a email e senha do formulario estão no banco de dados
					$sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$nova_senha'";
					$resultado = mysqli_query($conexao, $sql);

						if(mysqli_num_rows($resultado) == 1):
							$dados = mysqli_fetch_array($resultado);
							$_SESSION['logado'] = true;
							$_SESSION['usuario_id'] = $dados['usuario_id'];
							header("location: home.php");

						else:
							$erros[] = "<li> E-mail e senha não conferem </li>";
						endif;
				else:
					$erros[] = "<li> E-mail e senha não conferem </li>";
				endif;

            else:
                $erros[] = "<li> Usuário inexistente </li>";
            
		endif;

        endif;

    endif;

?>


<!DOCTYPE html>
<html lang="pt-br">  
<head>
	<title>Login</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style-login.css">
</head>
<!--Coded with love by Mutiullah Samim-->
<body>
	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img src="img/logo 1.jpeg" class="brand_logo" alt="Logo">
					</div>
				</div>
				<div class="d-flex justify-content-center form_container">
					<form action="login_novo.php" method="POST">
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="email" name="email" class="form-control input_user" value="" placeholder="Email">
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="senha" class="form-control input_pass" value="" placeholder="Senha">
						</div>
						<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="customControlInline">
								<label class="custom-control-label" for="customControlInline">Lembrar-me</label>
							</div>
						</div>
							<div class="d-flex justify-content-center mt-3 login_container">
				 	<button type="submit" name="button" class="btn login_btn">Login</button>
				   </div>
					</form>
				</div>

                 <!-- mostrando os erros na tela -->
                <?php
                    if(!empty($erros)):
                        foreach($erros as $erro):
                            echo $erro;
                        endforeach;
                    endif;
                ?>
		
				<div class="mt-4">
					<div class="d-flex justify-content-center links">
						Ainda não tem uma conta? <a href="cadastro_novo.php" class="ml-2">Cadastre-se</a>
					</div>
					<!--<div class="d-flex justify-content-center links">
						<a href="#">Forgot your password?</a>
					</div>-->
				</div>
			</div>
		</div>
	</div>
</body>
</html>
