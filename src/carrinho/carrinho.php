<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once "conection.php";
        mysqli_select_db($connect, $banco) or die("Erro na seleção do banco!");
    
        if(empty($_GET["produto"])){
            echo "SELECIONA UM CARAI";
        }
        else{
            foreach($_GET["produto"] as $produto){
                //echo $produto;
                
                $sql = "INSERT INTO `teste`.`produto` (`produto`.`id`, `produto`.`product`) VALUES (null, '". $produto. "');";

                if(mysqli_query($connect, $sql)){
                    $msg = "Gravado com sucesso!";

                    echo
                    "<script type='text/javascript'>
                        alert('$msg');
                    </script>";
                }
                else{
                    $msg = "Erro ao gravar!";

                    echo 
                    "<script type='text/javascript'>
                        alert('$msg');
                    </script>";
                }
            }
        }

        $query = "SELECT product FROM produto;";
        $result_query = mysqli_query($connect, $query) or die('Erro na query: '. $query. ' '. mysqli_error());

        while ($row = mysqli_fetch_array($result_query)){ 
            print $row["product"]. "<br>"; 
        }

    ?>
</body>
</html>