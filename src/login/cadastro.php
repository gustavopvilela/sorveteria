<!DOCTYPE html>
<html lang="eng">
<head>
	<meta charset = "UTF-8">
	<meta name= "viewport" content= "width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="../favicon/favicon.ico" type="image/x-icon">

	<link rel="stylesheet" href="estilo-login.css">

	<title>4everIced - Cadastro</title>
</head>
<body>
	<div class="container">
		<fieldset>
			<legend>Insira suas informações para o cadastro!</legend>
			
			<form action="#" method="get">
				<label for="nome">Nome: </label>
				<input type="text" name="nome" placeholder="Ex.: João da Silva" id="nome" class="input"><br>
				
				<label for="email">Email: </label>
				<input type="email" name="email" placeholder="nome@email.com" id="email" class="input"><br>
				
				<label for="senha">Senha: </label>
				<input type="password" name="senha" placeholder="Sua senha vai aqui!" id="senha" class="input"><br>
				
				<label for="rua">Rua: </label>
				<input type="text" name="rua" placeholder="Rua das Flores, 101" id="rua" class="input"><br>
				
				<label for="bairro">Bairro: </label>
				<input type="text" name="bairro" placeholder="Bairro Alfa" id="bairro" class="input"><br>
				
				<label for="telefone">Telefone: </label>
				<input type="text" name="telefone" placeholder="(XX) XXXXX-XXXX" id="telefone" class="input"><br>

				<input type="submit" value="Cadastrar!" name="cadastrar">
			</form>

			<hr>

			<div class="links">
				<a href="login.php">Já tem uma conta? Faça o login!</a><br>
				<a href="atualizar.php">Atualize seu cadastro!</a><br>
				<a href="deletar.php">Não está satisfeito? Delete sua conta!</a>
			</div>
			
		</fieldset>
	</div>
	<?php
		require_once "../../connection/connection.php";

		if(isset($_GET["cadastrar"])){
            
            $nome = $_GET["nome"];
            $email = $_GET["email"];
            $senha = $_GET["senha"];
            $rua = $_GET["rua"];
            $bairro = $_GET["bairro"];
            $telefone = $_GET["telefone"];
            
			$cadastro = "INSERT INTO `sorveteria`.`cliente` (`cliente`.`nome`, `cliente`.`email`, `cliente`.`senha`, `cliente`.`rua`, `cliente`.`bairro`, `cliente`.`telefone`) VALUES ('". $nome."', '". $email."', '". $senha."', '". $rua. "', '". $bairro. "', '". $telefone."');";
    		
            $cadastro_exe = mysqli_query($connect, $cadastro);

    		if(!$cadastro_exe){
                $msg = "Não foi possível cadastrar o usuário!";
                
                echo "<script> alert('". $msg."');
                location.href='cadastro.php';
                </script>";
            }
            
            else {
                $msg = "Usuário cadastrado com sucesso!";

				$id = "SELECT `cliente`.`id` FROM `sorveteria`.`cliente` WHERE `cliente`.`email` = '". $email. "';";

				$id_exe = mysqli_query($connect, $id);

				$row = mysqli_fetch_row($id_exe);
                
                echo "<script> alert('". $msg." Seu id de cliente é ". $row[0].", não esqueça!');
                location.href='login.php';
                </script>";
            }
		}
	?>
<body>
<html>