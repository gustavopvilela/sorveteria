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
        <label for="email">Digite o email atual para a atualizar: </label>
		<input type="email" name="email-cadastro" placeholder="nome@email.com" id="email"><br>
    
        <hr>

		<label for="nome">Novo nome: </label>
		<input type="text" name="nome" placeholder="Ex.: João da Silva" id="nome"><br>
		
		<label for="email">Novo email: </label>
		<input type="email" name="email" placeholder="nome@email.com" id="email"><br>
		
		<label for="senha">Nova senha: </label>
		<input type="password" name="senha" placeholder="Sua senha vai aqui!" id="senha"><br>
		
		<label for="rua">Nova rua: </label>
		<input type="text" name="rua" placeholder="Rua das Flores, 101" id="rua"><br>
		
		<label for="bairro">Novo bairro: </label>
		<input type="text" name="bairro" placeholder="Bairro Alfa" id="bairro"><br>
		
		<label for="telefone">Novo telefone: </label>
		<input type="text" name="telefone" placeholder="(XX) XXXXX-XXXX" id="telefone"><br>

		<input type="submit" value="Atualizar dados!" name="atualizar">
	</form>

	<a href="login.php">Já tem uma conta? Faça o login!</a><br>
	<a href="cadastro.php">Não tem uma conta? Faça seu cadastro!</a><br>
	<a href="deletar.php">Não está satisfeito? Delete sua conta!</a>

	<?php
		require_once "../pedido/carrinho/conection.php";

		if(isset($_GET["atualizar"])){
            $nome = $_GET["nome"];
            $email = $_GET["email"];
            $email_cadastro = $_GET["email-cadastro"];
            $senha = $_GET["senha"];
            $rua = $_GET["rua"];
            $bairro = $_GET["bairro"];
            $telefone = $_GET["telefone"];

            $query_select = "SELECT * FROM `sorveteria`.`cliente` WHERE `cliente`.`email` LIKE '$email_cadastro'";

            $select = mysqli_query($connect, $query_select);

            $row = mysqli_num_rows($select);
			
            if($row == 1){
                $atualizar = "UPDATE `sorveteria`.`cliente` SET `cliente`.`nome`='". $nome."', `cliente`.`email`='". $email."',`cliente`.`senha`='". $senha."',`cliente`.`rua`='". $rua."',`cliente`.`bairro`='". $bairro."',`cliente`.`telefone`='". $telefone."' WHERE `cliente`.`email` = '". $email_cadastro."';";
    		
                $atualizar_exe = mysqli_query($connect, $atualizar);

                if(!$atualizar_exe){
                    $msg = "Não foi possível atualizar o usuário! Alguns motivos podem ser: usuário não cadastrado ou dados inválidos.";
                    
                    echo "<script> alert('". $msg."');
                    location.href='login.php';
                    </script>";
                }
                else {
                    $msg = "Usuário atualizado com sucesso!";
                    
                    echo "<script> alert('". $msg."');
                    location.href='login.php';
                    </script>";
                }
            }
            else{
                $msg = "Usuário não encontrado nos registros! Impossível atualizar!";
                    
                echo "<script> alert('". $msg."');
                location.href='login.php';
                </script>";
            }
		}
	?>
<body>
<html>