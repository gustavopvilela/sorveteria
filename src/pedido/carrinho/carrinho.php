<?php
    if(isset($_GET["enviar"])){
        echo "<table><tr>";
        
        foreach($_GET["prod_id"] as $id){
            echo "<td>". $id. "</td>";
        }

        echo "</tr><tr>";

        foreach($_GET["prod_qtde"] as $qtde){
            echo "<td>". $qtde. "</td>";
        }
        
        echo "</tr><tr>";

        foreach($_GET["prod_valor"] as $valor){
            echo "<td>". $valor. "</td>";
        }

        echo "</tr></table>";
    }
?>