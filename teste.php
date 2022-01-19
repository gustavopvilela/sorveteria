<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once "src/pedido/carrinho/conection.php";

        $horaPedido = date_default_timezone_set('America/Sao_Paulo');
        $horaPedido = date('Y-m-d H:i:s', time());

        $horaEntrega = date_default_timezone_set("Etc/GMT+2");
        $horaEntrega = date('Y-m-d H:i:s', time());
    
        $venda = "INSERT INTO `sorveteria`.`vendas` (`vendas`.`valorTotal`, `vendas`.`dataEHoraVenda`, `dataEHoraEntrega`, `vendas`.`tipoEntrega`, `vendas`.`cliente_id`) VALUES (0, '". $horaPedido. "', '". $horaEntrega. "', 'Entrega em casa', 1);";

        $venda_exe = mysqli_query($connect, $venda);

        if (!$venda_exe) {
            echo "Não inseriu!";
            echo mysqli_error($connect);
        }
        else {
            echo "Inseriu!";
        }
    ?>
</body>
</html>