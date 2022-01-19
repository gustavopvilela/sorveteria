<?php
    require_once "../pedido/carrinho/conection.php"; // IMPORTA O ARQUIVO DE CONEXÃO
    
    session_start(); // INICIA A SESSÃO

    if(isset($_GET["add"])){ // SE O BOTÃO DE ADICIONAR AO CARINHO ESTIVER ATIVADO, FARÁ
        if(isset($_SESSION["carrinho"])){ // SE A SESSÃO TIVER DADOS NELA, FARÁ
            $item_array_id = array_column($_SESSION["carrinho"], "item_id"); // PEGA OS DADOS DE "item_id"

            if(!in_array($_GET["id"], $item_array_id)){ // SE O ITEM SELECIONADO JÁ NÃO TIVER SIDO ADICIONADO AO CARRINHO, ELE EXECUTARÁ ESSE BLOCO DE COMANDO
                $contar = count($_SESSION["carrinho"]); // CONTA O NÚMERO DE ELEMENTOS NO ARRAY E GUARDA EM $count

                $item_array = array(
                    'item_id'       => $_GET["id"],
                    'item_nome'     => $_GET["nome_hidden"],
                    'item_preco'    => $_GET["preco_hidden"],
                    'item_qtde'     => $_GET["qtde"]
                ); // GUARDA TODOS OS DADOS DO ITEM EM $item_array

                $_SESSION["carrinho"][$contar] = $item_array; // GUARDA OS DETALHES ANTES ADICIONADOS NA SESSÃO COM O ID CERTINHO
                
                foreach($_SESSION["carrinho"] as $keys => $values){
                    if($values["item_id"] == $_GET["id"]){
                            $insert = "INSERT INTO `sorveteria`.`produto_venda` (`produto_venda`.`quantidade`, `produto_venda`.`preco`, `produto_venda`.`produto_id`, `produto_venda`.`vendas_id`) VALUES (". $_GET["qtde"]. ", ". $_GET["preco_hidden"] * $_GET["qtde"]. ", ". $_GET["id"].", 1);";
    
                        $insert_query = mysqli_query($connect, $insert); 
                    }
                }
            }
            else{ // SE O ITEM JÁ TIVER SIDO ADICIONADO, ELE EXECUTA ESTE BLOCO DE COMANDO
                foreach($_SESSION["carrinho"] as $keys => $values){
                    if ($_SESSION["carrinho"][$keys]["item_id"] == $_GET["id"]) {
                        $_SESSION["carrinho"][$keys]["item_qtde"] = $_GET["qtde"];

                        $update = "UPDATE `sorveteria`.`produto_venda` SET `produto_venda`.`quantidade` = ". $_GET["qtde"]." WHERE `produto_venda`.`produto_id` = ". $_GET["id"].";";

                        $update_query = mysqli_query($connect, $update);

                        $update = "UPDATE `sorveteria`.`produto_venda` SET `produto_venda`.`preco` = ". $_GET["qtde"] * $_GET["preco_hidden"]." WHERE `produto_venda`.`produto_id` = ". $_GET["id"].";";

                        $update_query = mysqli_query($connect, $update);
                    }
                }
            }
        }
        else{ // SE A SESSÃO NÃO TIVER DADOS, DACLARARÁ O ARRAY QUE DECLARA  O QUE CADA COISA É E ARMAZENA NA SESSÃO
            $item_array = array(
                'item_id'       => $_GET["id"],
                'item_nome'     => $_GET["nome_hidden"],
                'item_preco'    => $_GET["preco_hidden"],
                'item_qtde'     => $_GET["qtde"]
            );
            
            $_SESSION["carrinho"][0] = $item_array;

            
        }
    }

    if(isset($_GET["action"])){ // SE "action" ESTIVER SETADO, FARÁ
        if($_GET["action"] == "delete"){ // SE "action" FOR IGUAL A "delete", FARÁ
            foreach($_SESSION["carrinho"] as $keys => $values){ // ACESSA OS DETALHES DE TODOS OS ITENS ARMAZENADOS NA SESSÃO
                if($values["item_id"] == $_GET["id"]){ // SE O $values FOR IGUAL AO ID DO ITEM QUE SERÁ REMOVIDO, FARÁ
                    unset($_SESSION["carrinho"][$keys]); // DESTRÓI O CONTEÚDO QUE ANTES FORA ARMAZENADO A CADA LOOP  QUE PASSA DO FOREACH, MAS SOMENTE SE O IF ANTERIOR FOR SATISFEITO

                    $delete = "DELETE FROM `sorveteria`.`produto_venda` WHERE `produto_venda`.`produto_id` = ". $_GET["id"]. ";";
                    $delete_query = mysqli_query($connect, $delete);
                    
                    echo '<script>alert("Item removido!");</script>'; // EMITE A MENSAGEM QUE O PRODUTO FOI REMOVIDO
                    
                    echo '<script>window.location="fazerpedido.php";</script>'; // MANDA O USUÁRIO NOVAMENTE À PÁGINA DE COMPRA
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Tags meta -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Scripts -->
    <script src="../fazerPedido/fazerpedido.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <!-- Links -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="fazerpedido.css">
    
    <link rel="shortcut icon" href="../favicon/favicon.ico" type="image/x-icon">

    <title>4everIced: Faça um pedido!</title>
</head>

<body>
    <!-- Barra de navegação -->
    <div class="barraNav">
        <div class="logo">
            <img src="../index/imgs/logo.png" alt="logo">
        </div>
        <div class="botao">
            <a href="../index/index.html"><input type="button" value="PÁGINA INICIAL" class="b-barraNav" id="primeiroBotao"></a>
        </div>

        <div class="botao">
            <a href="../cardapio/cardapio.html"><input type="button" value="CARDÁPIO" class="b-barraNav"></a>
        </div>

        <div class="botao" id="desabilitado">
            <input type="button" value="FAZER PEDIDO" class="b-barraNav" id="botaoDesabilitado">
        </div>

        <div class="botao">
            <a href="../contato/contate-nos.html"><input type="button" value="CONTATE-NOS" class="b-barraNav" id="ultimoBotao"></a>
        </div>
    </div>

    <!-- Fazer pedido -->
    <div class="container" style="width: 900px;">
        <h3 align="center">Faça um pedido na 4everIced!</h3>

        <?php
            $query = "SELECT * FROM `sorveteria`.`produto` ORDER BY `produto`.`id` ASC;"; // QUERY A SER EXECUTADA  

            $resultado = mysqli_query($connect, $query); // EXECUTA A QUERY

            if(mysqli_num_rows($resultado) > 0){ // ANALISA SE O NÚMERO DE LINHAS DA QUERY EXECUTADA É MAIOR QUE 0, SE SIM, FARÁ O BLOCO DE COMANDO
                while($row = mysqli_fetch_array($resultado)){ // ENQUANTO HOUVER LINHAS NA QUERY EXECUTADA, FARÁ O BLOCO DE COMANDO ABAIXO
        ?>
               <div class="col-md-4">
                   <form action="fazerpedido.php?action=add&id=<?php echo $row["id"]; // AÇÃO QUE ADICIONA NO CARRINHO ?>" method="get">
                       <div style="border: 1px solid black;
                                   background-color: #f1f1f1;
                                   border-radius: 5px;
                                   padding: 16px;
                                   margin-bottom: 25px;
                                   align: center"
                            id="produtos">

                            <img src="<?php echo $row["image"]; // MOSTRA A IMAGEM DO PRODUTO ?>" class="img-responsive" />
                            
                            <br>

                           <h4 class="text-info" style="text-align: center;">
                               <?php echo $row["nome"]; // MOSTRA O NOME DO PRODUTO ?>
                           </h4>

                           <h4 class="text-danger" style="text-align: center;">
                               R$ 
                               <?php echo number_format($row["preco"], 2, ",", "."); // MOSTRA O PREÇO DO PRODUTO ?>
                           </h4>

                           <input type="number" name="qtde" class="form-control" value="1">
                           
                           <input type="hidden" name="nome_hidden" value="<?php echo $row["nome"]; // PARA USO POSTERIOR NA ADIÇÃO, ATUALIZAÇÃO E DELEÇÃO ?>">

                           <input type="hidden" name="preco_hidden" value="<?php echo $row["preco"]; // PARA USO POSTERIOR NA ADIÇÃO, ATUALIZAÇÃO E DELEÇÃO ?>">

                           <input type="hidden" name="id" value="<?php echo $row["id"]; // PARA USO POSTERIOR NA ADIÇÃO, ATUALIZAÇÃO E DELEÇÃO ?>">

                           <div class="text-center">
                                <input type="submit" style="margin-top: 5px; align: center;" value="Adicionar ao carrinho &#127846;" name="add" class="btn btn-success">
                           </div>
                       </div>
                   </form>
                </div> 
        <?php
                }
            }
        ?>

        <div style="clear: both;"></div>
        <br>
        <h3>Detalhes do pedido</h3>

        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 40%">Nome do item</th>
                    <th style="width: 10%">Quantidade</th>
                    <th style="width: 20%">Preço</th>
                    <th style="width: 15%">Total</th>
                    <th style="width: 5%">Remover</th>
                </tr>

                <?php
                    if(!empty($_SESSION["carrinho"])){ // SE A SESSÃO NÃO ESTIVER VAZIA, ELE EXECUTARÁ ESTE BLOCO DE COMANDO
                        $total = 0; // VARIÁVEL DE TOTAL DE PREÇO

                        foreach($_SESSION["carrinho"] as $keys => $values){ // ACESSA TODOS OS ITENS DA SESSÃO E EXECUTA O BLOCO ABAIXO
                ?>
                            <tr>
                                <td>
                                    <?php
                                        echo $values["item_nome"];
                                        // MOSTRA O NOME DO PRODUTO
                                    ?>
                                </td>

                                <td>
                                    <?php
                                        echo $values["item_qtde"];
                                        // MOSTRA A QUANTIDADE DO PRODUTO
                                    ?>
                                </td>

                                <td>
                                    <?php
                                        echo "R$". number_format($values["item_preco"], 2, ",", ".");
                                        // MOSTRA O PREÇO DO PRODUTO
                                    ?>
                                </td>

                                <td>
                                    <?php
                                        echo "R$". number_format($values["item_qtde"] * $values["item_preco"], 2, ",", ".");
                                        // CALCULA O SUBTOTAL DO ITEM MULTIPLICANDO A QUANTIDADE COM O PREÇO DELE
                                    ?>
                                </td>

                                <td>
                                    <a href='fazerpedido.php?action=delete&id=<?php echo $values["item_id"]; // LINK PARA REMOVER O ITEM DA SESSÃO ?>'>Remover item</a>
                                </td>
                            </tr>
                <?php
                            $total = $total + ($values["item_qtde"] * $values["item_preco"]);
                            // CALCULA O VALOR TOTAL DA COMPRA, ADICIONANDO A CADA ITEM QUE FOI ADICIONADO AO CARRINHO E, AO MESMO TEMPO, DIMINUI O PREÇO À MEDIDA QUE OS ITENS VÃO SENDO RETIRADOS.
                        }
                ?>

                            <tr>
                                <td colspan="3" align="right">Total</td>

                                <td align="right">
                                    <?php
                                        echo "R$". number_format($total, 2, ",", ".");
                                        // MOSTRA O TOTAL
                                    ?>
                                </td>

                                <td></td>
                            </tr>
                <?php
                    }
                ?>
            </table>
        </div>

        <form action="#" method="get">
            <div align="right">
                <input type="submit" style="margin: 5px 0 10px 0;" value="Finalizar pedido" name="finalizar"  class="btn btn-success">
            </div>

            <?php
                if(isset($_GET["finalizar"])){
                    session_destroy(); // DESTRÓI TODOS OS DADOS ARMAZENADOS NA SESSÃO

                    echo '<script>alert("Pedido finalizado! Em até 60 minutos ele estará pronto e entregue!");</script>';
                    
                    echo '<script>window.location="../index/index.html";</script>';
                }
            ?>
        </form>
    </div>
</body>
</html>