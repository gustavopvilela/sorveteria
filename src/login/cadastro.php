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

		<input type="submit" value="Cadastrar!" name="cadastrar">
	</form>

	<a href="login.php">Já tem uma conta? Faça o login!</a><br>
	<a href="atualizar.php">Atualize seu cadastro!</a><br>
	<a href="deletar.php">Não está satisfeito? Delete sua conta!</a>

	<?php
		require_once "../pedido/carrinho/conection.php";

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
                location.href='login.php';
                </script>";
            }
            
            else {
                $msg = "Usuário cadastrado com sucesso!";
                
                echo "<script> alert('". $msg."');
                location.href='login.php';
                </script>";
            }
		}
	?>
<body>
<html>