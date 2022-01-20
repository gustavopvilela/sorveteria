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
		<label for="email">Digite o email da conta que quer excluir: </label>
		<input type="email" name="email" placeholder="nome@email.com" id="email"><br>

        <label for="senha">Digite a senha para confirmar a exclusão: </label>
		<input type="password" name="senha" placeholder="Sua senha vai aqui!" id="senha"><br>

		<input type="submit" value="Excluir!" name="excluir">
	</form>

	<a href="login.php">Já tem uma conta? Faça o login!</a><br>
	<a href="cadastro.php">Não tem uma conta? Cadastre-se!</a><br>
	<a href="atualizar.php">Atualize seu cadastro!</a>

	<?php
		require_once "../pedido/carrinho/conection.php";

		if(isset($_GET["excluir"])){
            $email_cadastro = $_GET["email"];
            $senha = $_GET["senha"];
            
			$query_select = "SELECT * FROM `sorveteria`.`cliente` WHERE `cliente`.`email` LIKE '$email_cadastro' AND `cliente`.`senha` = '$senha'";

            $select = mysqli_query($connect, $query_select);

            /* $cliente_id = "SELECT `vendas`.`cliente_id` FROM `sorveteria`.`vendas` WHERE `vendas`.`cliente_id` = (SELECT `cleinte`.`id` FROM `sorveteria`.`cliente` WHERE `cliente`.`email` LIKE '$email_cadastro' AND `cliente`.`senha` = '$senha');";

            $cliente_id_exe = mysqli_query($connect, $cliente_id); */

            $row = mysqli_num_rows($select);
			
            if($row == 1){
                /* $deletar_vendas = "DELETE FROM `sorveteria`.`vendas` WHERE `vendas`.`cliente_id` = ". $cliente_id_exe.";";

                $deletar_vendas_exe = mysqli_query($connect, $deletar_vendas); */
                
                $deletar = "DELETE FROM `sorveteria`.`cliente` WHERE `cliente`.`email` = '". $email_cadastro. "';";
    		
                $deletar_exe = mysqli_query($connect, $deletar);

                if(!$deletar_exe){
                    $msg = "Não foi possível deletar o usuário!";
                    
                    echo "<script> alert('". $msg.", ". mysqli_error($connect)."');
                    location.href='login.php';
                    </script>";

                    echo mysqli_error($connect);
                }
                else {
                    $msg = "Usuário deletado com sucesso!";
                    
                    echo "<script> alert('". $msg."');
                    location.href='login.php';
                    </script>";
                }
            }
            else{
                $msg = "Usuário não encontrado nos registros! Impossível deletar!";
                    
                echo "<script> alert('". $msg."');
                location.href='login.php';
                </script>";
            }
		}
	?>
<body>
<html>