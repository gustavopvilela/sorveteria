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
		<label for="nome">Nome: </label>
		<input type="text" name="nome" placeholder="Ex.: João da Silva" id="nome"><br>
		
		<label for="email">Email: </label>
		<input type="email" name="email" placeholder="nome@email.com" id="email"><br>
		
		<label for="senha">Senha: </label>
		<input type="password" name="senha" placeholder="Sua senha vai aqui!" id="senha"><br>
		
		<label for="rua">Rua: </label>
		<input type="text" name="rua" placeholder="Rua das Flores, 101" id="rua"><br>
		
		<label for="bairro">Bairro: </label>
		<input type="text" name="bairro" placeholder="Bairro Alfa" id="bairro"><br>
		
		<label for="telefone">Telefone: </label>
		<input type="text" name="telefone" placeholder="(XX) XXXXX-XXXX" id="telefone"><br>

		<input type="submit" value="Logar!" name="logar">
	</form>

	<a href="">Não tem uma conta? Cadastre-se!</a>
	<a href="">Atualize seu cadastro!</a>
	<a href="">Não está satisfeito? Delete sua conta!</a>

	<?php
		require_once "../pedido/carrinho/conection.php";

		if(isset($_GET["logar"])){
			$nome = $_GET["nome"];
			$email = $_GET["email"];
			$senha = $_GET["senha"];
			$rua = $_GET["rua"];
			$bairro = $_GET["bairro"];
			$telefone = $_GET["telefone"];
			
			$query_select = "SELECT * FROM `cliente` WHERE `login` LIKE '$login' AND `senha` LIKE '$senha'";

    		// consulta um usuário já inserido no banco
    		$select = mysqli_query($connect, $query_select);

    		// retorna a quantidade de linhas encontradas
    		$row = mysqli_num_rows($select);

    		// emite mensagem caso o usuário tenha sido encontrado
			if($row == 1){
				echo
				"<script type='text/javascript'>
					alert('Login efetuado com sucesso!');

					location.href='formulario.html';
				</script>";
			}
			else{
				echo
				"<script type='text/javascript'>
					alert('Usuário/senha não cadastrados!');

					location.href='formulario.html';
				</script>";
			}
		}
	?>
<body>
<html>