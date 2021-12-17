function showBill(){
    var botao = document.querySelector("#botaoFazerPedido");
    var pedido = document.querySelector("#pedido");
    var valorDoPedido = pedido.value;

    /* Substituir ; por quebras de linha ao ser mostrada a nota fiscal */
    for(var i = 0; i < valorDoPedido.length; i++){
        valorDoPedido = valorDoPedido.replace(";", "\<br\>");
    }

    if(valorDoPedido == ""){
        window.alert("Não há nenhum item no seu pedido!");
        location.reload();
    }
    else{
        document.querySelector("#notaFiscal").innerHTML = valorDoPedido;
    }
}

/* Mostrar div a partir de um botão */
function showDiv(a){
    var display = document.getElementById(a).style.display;

    if(display == "none"){
        document.getElementById(a).style.display = "block";
    }
    else if(display == "block"){
        document.getElementById(a).style.display = "none";
    }
}

/* Mostrar div a partir de uma seleção radio */
function ativarDiv(a){
    document.getElementById(a).style.display = "block";
}

function desativarDiv(b){
    document.getElementById(b).style.display = "none";
}