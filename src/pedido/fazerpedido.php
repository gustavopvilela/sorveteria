<?php
    require_once "../pedido/carrinho/conection.php";
    
    session_start();

    if(isset($_GET["add"])){
        if(isset($_SESSION["carrinho"])){
            $item_array_id = array_column($_SESSION["carrinho"], "item_id");

            if(!in_array($_GET["id"], $item_array_id)){
                $contar = count($_SESSION["carrinho"]);

                $item_array = array(
                    'item_id'       => $_GET["id"],
                    'item_nome'     => $_GET["nome_hidden"],
                    'item_preco'    => $_GET["preco_hidden"],
                    'item_qtde'     => $_GET["qtde"]
                );

                $_SESSION["carrinho"][$contar] = $item_array;
            }
            else{
                echo '<script>alert("Item já adicionado!");</script>';
                echo '<script>window.location="fazerpedido.php";</script>';
            }
        }
        else{
            $item_array = array(
                'item_id'       => $_GET["id"],
                'item_nome'     => $_GET["nome_hidden"],
                'item_preco'    => $_GET["preco_hidden"],
                'item_qtde'     => $_GET["qtde"]
            );
            
            $_SESSION["carrinho"][0] = $item_array;
        }
    }

    if(isset($_GET["action"])){
        if($_GET["action"] == "delete"){
            foreach($_SESSION["carrinho"] as $key => $values){
                if($values["item_id"] == $_GET["id"]){
                    unset($_SESSION["carrinho"][$keys]);
                    
                    echo '<script>alert("Item removido!");</script>';
                    
                    echo '<script>window.location="fazerpedido.php";</script>';
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
    <link rel="shortcut icon" href="../favicon/favicon.ico" type="image/x-icon">
    

    <title>4everIced: Faça um pedido!</title>
</head>

<body>
    <!-- Barra de navegação -->
    <!-- <div class="barraNav">
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
    </div> -->

    <!-- Fazer pedido -->
    <div class="container">
        <h3>Compras</h3>

        <?php
            $query = "SELECT * FROM `sorveteria`.`produto` ORDER BY `produto`.`id` ASC;";

            $resultado = mysqli_query($connect, $query);

            if(mysqli_num_rows($resultado) > 0){
                while($row = mysqli_fetch_array($resultado)){
        ?>
               <div>
                   <form action="fazerpedido.php?action=add&id=<?php echo $row["id"]; ?>" method="get">
                       <div style="border: 1px solid black; background-color: #f1f1f1; border-radius: 5px;">
                           <!-- <img src="tem um php aq" alt="imagem"> -->

                           <h4 class="info">
                               <?php echo $row["nome"]; ?>
                           </h4>

                           <h4 class="preco">
                               R$ 
                               <?php echo number_format($row["preco"], 2, ",", "."); ?>
                           </h4>

                           <input type="text" name="qtde" value="1">
                           
                           <input type="hidden" name="nome_hidden" value="<?php echo $row["name"]; ?>">

                           <input type="hidden" name="preco_hidden" value="<?php echo $row["preco"]; ?>">

                           <input type="submit" style="margin-top: 5px;" value="Adicionar ao carrinho" name="add">
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

        <div class="tabela">
            <table style="border: 1pxx solid black">
                <tr>
                    <th style="width: 40%">Nome do item</th>
                    <th style="width: 10%">Quantidade</th>
                    <th style="width: 20%">Preço</th>
                    <th style="width: 15%">Total</th>
                    <th style="width: 5%">Remover</th>
                </tr>

                <?php
                    if(!empty($_SESSION["carrinho"])){
                        $total = 0;

                        foreach($_SESSION["carrinho"] as $keys => $values){
                ?>
                            <tr>
                                <td>
                                    <?php
                                        echo $values["item_nome"];
                                    ?>
                                </td>

                                <td>
                                    <?php
                                        echo $values["item_qtde"];
                                    ?>
                                </td>

                                <td>
                                    <?php
                                        echo "R$". number_format($values["item_preco"], 2, ",", ".");
                                    ?>
                                </td>

                                <td>
                                    <?php
                                        echo "R$". number_format($values["item_qtde"] * $values["item_preco"], 2, ",", ".");
                                    ?>
                                </td>

                                <td>
                                    <a href='fazerpedido.php?action=delete&id=<?php echo $values["item_id"]; ?>'>Remover item</a>
                                </td>
                            </tr>
                <?php
                            $total = $total + ($values["item_qtde"] * $values["item_preco"]);
                        }
                ?>

                            <tr>
                                <td colspan="3" align="right">Total</td>

                                <td align="right">
                                    <?php
                                        echo "R$". number_format($total, 2, ",", ".");
                                    ?>
                                </td>

                                <td></td>
                            </tr>
                <?php
                    }
                ?>
            </table>
        </div>
    </div>
</body>
</html>