<?php

    //conexão com o banco de dados
    require_once 'conexao.php';

    // pegando o click do botao cadastrar
    if(isset($_POST['button'])):
        $erros = array();
        $nome = mysqli_escape_string($conexao, $_POST['nome']);
        $telefone =  mysqli_escape_string($conexao, $_POST['telefone']);
        $email = mysqli_escape_string($conexao, $_POST['email']);
        $senha = mysqli_escape_string($conexao, $_POST['senha']);
        $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

        // Verificando se os campos estão vazios
        if(empty($nome) or empty($telefone) or empty($email) or empty($senha)):
            $erros[] = "<li> Todos os campos precisam ser preenchidos </li><br>";

        // Verificando o tamanho da senha
        elseif(strlen($senha) < 8 or strlen($senha) > 15):
            $erros[] = "<li> A senha precisa ter entre 8 e 15 caracteres </li><br>";

        // verificando se o email passado ja está cadastrado no banco de dados
        else:
            $sql = "SELECT email FROM usuarios WHERE email = '$email'";
            $resultado = mysqli_query($conexao, $sql);

            if(mysqli_num_rows($resultado) > 0):
                $erros[] = "<li> E-mail já cadastrado </li><br>";
                
            else:
                $result = "INSERT INTO usuarios(nome,telefone,email,senha) VALUES ('$nome','$telefone','$email','$senha_criptografada')";
                
            if(mysqli_query($conexao, $result)):
                header("location: Login_novo.php?sucesso");
                
            else:
                header("location: Cadastro_novo.php?erro");
            endif;
            endif;
        
        endif;

    endif;

?>



<!DOCTYPE html>
<html lang="pt-br">  
<head>
	<title>Cadastro</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style-cadastro.css">
    
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
					<form action="cadastro_novo.php" method="POST">
						<div class="input-group mb-3">
                            <div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-home fa-fw"></i></span>
							</div>
							<input type="text" name="nome" class="form-control input_user" value="" placeholder="Nome da empresa">
						</div>
                        <div class="input-group mb-3">
                        <div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span>
						</div>
							<input type="text" name="telefone" class="form-control input_user" value="" placeholder="Telefone">
						</div>
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
						
							<div class="d-flex justify-content-center mt-3 login_container">
				 	<button type="submit" name="button" class="btn login_btn">Cadastrar</button>
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

			</div>
		</div>
	</div>
	
</body>
</html>