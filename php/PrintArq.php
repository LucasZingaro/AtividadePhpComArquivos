<?php

require_once 'php/Compra.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PrintArq
 *
 * @author Aluno
 */
class PrintArq {

    public static $ARQUIVO = "Compras.txt";

    public static function salvarCompra($Compra) {
        $ARQUIVO = PrintArq::$ARQUIVO;
        try {
            $obj = new Compra();
            $obj = unserialize($Compra);
            //$obj=$Compra;
            $fp = fopen("$ARQUIVO", "a"); // abre o arquivo
            $args = $obj->getALL($Compra);
            $str = "\n" . $args[_CIDADE] . ", " . PrintArq::dataToPTBR($args[_DATA])
                    . "\nNome do Cliente: " . $args[_NOMECLIENTE];

            $produtos = $args[_PRODUTOS];
            for ($i = 0; $i < count($produtos); $i++) {
                $str .= "\n" . $produtos[$i];
            }
            if ($args[_DESCONTO] > 0) {
                $str .= "\nDesconto: - R$" . $obj->getDesconto();
            }
            $str .= "\nValor Final: R$ " . $obj->getValor()
                    . "\nValidade: " . PrintArq::dataToPTBR($args[_VALIDADE]) . "\n\n";


            fwrite($fp, $str); // grava no arquivo. Se o arquivo não existir ele será criado
            fclose($fp);
            return $str;
        } catch (Exception $e) {
            return "ERRO:salvarCompra(Compra): $e";
        }
    }

    public static function RecuperarCompras() {
        $ARQUIVO = PrintArq::$ARQUIVO;
        if (file_exists($ARQUIVO)) {
            try {
                $fp = fopen("$ARQUIVO", "r");
                $char = "";
                while (!feof($fp)) {
                    try {
                        $char .= fgetc($fp);
                    } catch (Exception $exc) {
                        break;
                    }
                }
                fclose($fp);
                return nl2br($char);
            } catch (Exception $e) {
                return "ERRO:RecuperarCompras(): $e";
            }
        } else {
            return "Nenhuma compra encontrada";
        }
    }

    public static function dataToPTBR($data) {
        $str = "dd/mm/Y - H:i:s";
        $str = $data;
        $d = substr($str, 0, 2);
        $m = substr($str, 3, 2);
        $y = substr($str, 6);
        switch ($m) {
            case "01": $m = "Janeiro";
                break;
            case "02": $m = "Fevereiro";
                break;
            case "03": $m = "Março";
                break;
            case "04": $m = "Abril";
                break;
            case "05": $m = "Maio";
                break;
            case "06": $m = "Junho";
                break;
            case "07": $m = "Julho";
                break;
            case "08": $m = "Agosto";
                break;
            case "09": $m = "Setembro";
                break;
            case "10": $m = "Outubro";
                break;
            case "11": $m = "Novembro";
                break;
            case "12": $m = "Dezembro";
                break;
        }
        return "$d de $m de $y";
    }

    /*
      //TRABALHANDO COM ARQUIVO TEXTO EM PHP_ROUND_HALF_UP
      //
      $fp = fopen("arquivo.txt", "w"); // abre o arquivo
      fwrite($fp, "Olá mundo do PHP!"); // grava no arquivo. Se o arquivo não existir ele será criado
      fclose($fp); // fecha o arquivo
      //
      //
      $fp = fopen("arquivo.txt", "r");
      $texto = fread($fp, 20); // lê 20 bytes do arquivo e armazena em $texto
      fclose($fp);
      echo $texto;
      //
      //Para ler todo conteúdo de um arquivo utilize o fgetc
      //
      $fp = fopen("dados.txt", "r");
      while (!feof($fp)){
      $char .= fgetc($fp);
      }
      fclose($fp);
      echo $char."<br><br>";
      //
      //Para colocar o conteúdo do arquivo em um array utilize:
      //
      $fd = fopen ("texto.txt", "r");
      while (!feof ($fd)){
      $buffer = fgets($fd, 4096);
      $lines[] = $buffer;
      }
      fclose ($fd);
      //
     */
}
