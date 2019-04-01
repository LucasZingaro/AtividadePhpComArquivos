<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Produtos
 *
 * @author Lucas
 */
class Produtos {

    private static $jasonProd = 'json/Produtos.json';

    public static function getTodos() {
        $arquivo = file_get_contents(Produtos::$jasonProd);
        // Decodifica o formato JSON e retorna um Objeto
        $json=json_decode($arquivo);
        return $json;
    }

    public static function toString($produtos) {
        $str = "";
        foreach ($produtos as $registro):
            $str += "\nNome:" . $produtos->nome;
            $str += "\nPeço:" . number_format($produtos->valor, 2, ",", ".");
            $str += "\nImg:" . $produtos->img;
        endforeach;
        return $str;
    }

    public static function getAllToArray() {
        $i = 0;$arr=[];
        foreach (Produtos::getTodos() as $p):
            array_push($arr, $p);
            $i++;
        endforeach;
        return $arr;
    }

}
