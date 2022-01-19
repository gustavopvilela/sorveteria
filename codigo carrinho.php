<?php   
	session_start(); // INICIA SESSÃO 

	$connect = mysqli_connect("localhost", "root", "", "test"); // CONECTA NO BD

	if(isset($_POST["add_to_cart"])){ // SE O BOTÃO DE ADICIONAR AO CARINHO ESTIVER ATIVADO, FARÁ
		if(isset($_SESSION["shopping_cart"])){ // SE A SESSÃO TIVER DADOS NELA, FARÁ
			$item_array_id = array_column($_SESSION["shopping_cart"], "item_id"); // PEGA OS DADOS DE "item_id"

			if(!in_array($_GET["id"], $item_array_id)){ // SE O ITEM SELECIONADO JÁ NÃO TIVER SIDO ADICIONADO AO CARRINHO, ELE EXECUTARÁ ESSE BLOCO DE COMANDO 
				$count = count($_SESSION["shopping_cart"]); // CONTA O NÚMERO DE ELEMENTOS NO ARRAY E GUARDA EM $count
				
				$item_array = array(  
					'item_id'               =>     $_GET["id"],  
					'item_name'             =>     $_POST["hidden_name"],  
					'item_price'            =>     $_POST["hidden_price"],  
					'item_quantity'         =>     $_POST["quantity"]  
				); // GUARDA TODOS OS DADOS DO ITEM EM $item_array
				
				$_SESSION["shopping_cart"][$count] = $item_array; // GUARDA OS DETALHES ANTES ADICIONADOS NA SESSÃO COM O ID CERTINHO
			}  
			else{ // SE O ITEM JÁ TIVER SIDO ADICIONADO, ELE EXECUTA ESTE BLOCO DE COMANDO
				echo '<script>alert("Item Already Added")</script>'; // APARECE A MSG DE ITEM JÁ DIRECIONADO
				echo '<script>window.location="index.php"</script>'; // VOLTA À PÁGINA DE COMPRA
			}  
		}  
		else{ // SE A SESSÃO NÃO TIVER DADOS, DACLARARÁ O ARRAY QUE DECLARA  O QUE CADA COISA É E ARMAZENA NA SESSÃO
			$item_array = array(  
				'item_id'               =>     $_GET["id"],  
				'item_name'             =>     $_POST["hidden_name"],  
				'item_price'            =>     $_POST["hidden_price"],  
				'item_quantity'         =>     $_POST["quantity"]  
			);  

			$_SESSION["shopping_cart"][0] = $item_array;  
		}  
	}  

	if(isset($_GET["action"])){ // SE "action" ESTIVER SETADO, FARÁ
		if($_GET["action"] == "delete"){ // SE "action" FOR IGUAL A "delete", FARÁ
			foreach($_SESSION["shopping_cart"] as $keys => $values){ // ACESSA OS DETALHES DE TODOS OS ITENS ARMAZENADOS NA SESSÃO
				if($values["item_id"] == $_GET["id"]){ // SE O $values FOR IGUAL AO ID DO ITEM QUE SERÁ REMOVIDO, FARÁ 
					unset($_SESSION["shopping_cart"][$keys]); // DESTRÓI O CONTEÚDO QUE ANTES FORA ARMAZENADO A CADA LOOP  QUE PASSA DO FOREACH, MAS SOMENTE SE O IF ANTERIOR FOR SATISFEITO

					echo '<script>alert("Item Removed")</script>'; // EMITE A MENSAGEM QUE O PRODUTO FOI REMOVIDO
					echo '<script>window.location="index.php"</script>'; // MANDA O USUÁRIO NOVAMENTE À PÁGINA DE COMPRA
				}  
			}  
		}  
	}  
?>  

<!DOCTYPE html>  
<html>  
<head>  
	<title>Webslesson Tutorial | Simple PHP Mysql Shopping Cart</title>  
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
</head>  
<body>  
	<br />  

	<div class="container" style="width:700px;">  
		<h3 align="center">Simple PHP Mysql Shopping Cart</h3><br />  
<?php  
	$query = "SELECT * FROM tbl_product ORDER BY id ASC"; // QUERY A SER EXECUTADA  

	$result = mysqli_query($connect, $query); // EXECUTA A QUERY

	if(mysqli_num_rows($result) > 0){ // ANALISA SE O NÚMERO DE LINHAS DA QUERY EXECUTADA É MAIOR QUE 0, SE SIM, FARÁ O BLOCO DE COMANDO
		while($row = mysqli_fetch_array($result)){ // ENQUANTO HOUVER LINHAS NA QUERY EXECUTADA, FARÁ O BLOCO DE COMANDO ABAIXO
?>  

	<div class="col-md-4">  
		<form method="post" action="index.php?action=add&id=<?php echo $row["id"]; // AÇÃO QUE ADICIONA NO CARRINHO ?>">  
			<div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">  
				<img src="<?php echo $row["image"]; // MOSTRA A IMAGEM DO PRODUTO ?>" class="img-responsive" /><br />  
				<h4 class="text-info"><?php echo $row["name"]; // MOSTRA O NOME DO PRODUTO ?></h4>  
				<h4 class="text-danger">$ <?php echo $row["price"]; // MOSTRA O PREÇO DO PRODUTO ?></h4>  

				<input type="text" name="quantity" class="form-control" value="1" />  
				<input type="hidden" name="hidden_name" value="<?php echo $row["name"]; // PARA USO POSTERIOR NA ADIÇÃO, ATUALIZAÇÃO E DELEÇÃO ?>" />  
				<input type="hidden" name="hidden_price" value="<?php echo $row["price"]; // PARA USO POSTERIOR NA ADIÇÃO, ATUALIZAÇÃO E DELEÇÃO ?>" />  
				<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />  
			</div>  
		</form>  
	</div>  

<?php  
		}  
	}  
?> 
 
	<div style="clear:both"></div>  

	<br />  

	<h3>Order Details</h3>  
	
	<div class="table-responsive">  
		<table class="table table-bordered">  
			<tr>  
				<th width="40%">Item Name</th>  
				<th width="10%">Quantity</th>  
				<th width="20%">Price</th>  
				<th width="15%">Total</th>  
				<th width="5%">Action</th>  
			</tr>  

<?php   
	if(!empty($_SESSION["shopping_cart"])){ // SE A SESSÃO NÃO ESTIVER VAZIA, ELE EXECUTARÁ ESTE BLOCO DE COMANDO
		$total = 0;  // VARIÁVEL DE TOTAL DE PREÇO
		
		foreach($_SESSION["shopping_cart"] as $keys => $values){ // ACESSA TODOS OS ITENS DA SESSÃO E EXECUTA O BLOCO ABAIXO
?>  

			<tr>  
				<td><?php echo $values["item_name"]; // MOSTRA O NOME DO PRODUTO ?></td>  
				<td><?php echo $values["item_quantity"]; // MOSTRA A QUANTIDADE DO PRODUTO ?></td>  
				<td>$ <?php echo $values["item_price"]; // MOSTRA O PREÇO DO PRODUTO ?></td>  
				<td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); // CALCULA O SUBTOTAL DO ITEM MULTIPLICANDO A QUANTIDADE COM O PREÇO DELE ?></td>  
				<td><a href="index.php?action=delete&id=<?php echo $values["item_id"]; // LINK PARA REMOVER O ITEM DA SESSÃO ?>"><span class="text-danger">Remove</span></a></td>  
			</tr>  

<?php  
		$total = $total + ($values["item_quantity"] * $values["item_price"]); // CALCULA O VALOR TOTAL DA COMPRA, ADICIONANDO A CADA ITEM QUE FOI ADICIONADO AO CARRINHO E, AO MESMO TEMPO, DIMINUI O PREÇO À MEDIDA QUE OS ITENS VÃO SENDO RETIRADOS.
		
		}
?>  

			<tr>  
				<td colspan="3" align="right">Total</td>  
				<td align="right">$ <?php echo number_format($total, 2); // MOSTRA O TOTAL ?></td>  
				<td></td>  
			</tr>  

<?php  
	}  
?>  

		</table>  
	</div>  
	</div>  
	<br />  
</body>  
</html>