<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define("_DATA", 0);
define("_CIDADE", 1);
define("_NOMECLIENTE", 2);
define("_PRODUTOS", 3);
define("_VALOR", 4);
define("_DESCONTO", 5);
define("_VALIDADE", 6);

/**
 * Description of Compra
 *
 * @author Aluno
 */
class Compra {

    var $data;
    var $cidade;
    var $nomeCliente;
    var $produtos = [];
    var $valor;
    var $desconto;
    var $validade;

    function getValor() {
        return number_format($this->valor, 2, ",", ".");
    }

    function setValor($valor) {
        $this->valor = number_format($valor, 2, ".", ",");
    }
    
    function getDesconto() {
        return number_format($this->desconto, 2, ",", ".");
    }

    function setDesconto($desc) {
        $this->desconto = number_format($desc, 2, ".", ",");
    }

    function getALL($obj) {
        $obj = unserialize($obj);
        $all = [$obj->data, $obj->cidade, $obj->nomeCliente, $obj->produtos, $obj->valor, $obj->desconto, $obj->validade];
        return $all;
    }

    function setALL($args, $obj) {
        $args = unserialize($args);
        $obj->data = $args[_DATA];
        $obj->cidade = $args[_CIDADE];
        $obj->nomeCliente = $args[_NOMECLIENTE];
        $obj->produtos = $args[_PRODUTOS];
        $obj->setValor($args[_VALOR]);
        $obj->setDesconto($args[_DESCONTO]);
        $obj->validade = $args[_VALIDADE];
    }

    public static function getStrProd($nome,$valor,$qtd,$total) {
        return "Produto: $nome | "
             . "Preço: R$ " . number_format($valor, 2, ",", ".") . " | "
             . "Quantidade: $qtd | "
             . "Total: R$ " . number_format($total, 2, ",", ".") . ";";
    }

}

/*
$objCarro = new Carro();
$objCarro->setCor(Cores::azul);
$srlCarro = serialize($objCarro);

<input type="hidden" name="carrinho" value ="<?=$srlCarro?>" />

e na outra pagina

$objCarro = unserialize($_POST['carrinho']);

echo $objCarro->getCor();
 */