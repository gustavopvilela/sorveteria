<!DOCTYPE html>
<html lang="eng">
<head>
	<meta charset = "UTF-8">
	<meta name= "viewport" content= "width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="../favicon/favicon.ico" type="image/x-icon">

	<title>4everIced - Login</title>
</head>
<body>
	<form action="#" method="get">
		<label for="email">Email: </label>
		<input type="email" name="email" placeholder="nome@email.com" id="email"><br>
		
		<label for="senha">Senha: </label>
		<input type="password" name="senha" placeholder="Sua senha vai aqui!" id="senha"><br>

		<input type="submit" value="Logar!" name="logar">
	</form>

	<a href="cadastro.php">Não tem uma conta? Cadastre-se!</a><br>
	<a href="atualizar.php">Atualize seu cadastro!</a><br>
	<a href="deletar.php">Não está satisfeito? Delete sua conta!</a>

	<?php
		require_once "../pedido/carrinho/conection.php";

		if(isset($_GET["logar"])){
			$email = $_GET["email"];
			$senha = $_GET["senha"];
			
			$query_select = "SELECT * FROM `sorveteria`.`cliente` WHERE `cliente`.`email` LIKE '$email' AND `cliente`.`senha` LIKE '$senha'";

    		// consulta um usuário já inserido no banco
    		$select = mysqli_query($connect, $query_select);

    		// retorna a quantidade de linhas encontradas
    		$row = mysqli_num_rows($select);

    		// emite mensagem caso o usuário tenha sido encontrado
			if($row == 1){
				echo
				"<script type='text/javascript'>
					alert('Login efetuado com sucesso!');

					location.href='../index/index.html';
				</script>";
			}
			else{
				echo
				"<script type='text/javascript'>
					alert('Usuário/senha não cadastrados!');

					location.href='../index/index.html';
				</script>";
			}
		}
	?>
<body>
<html>