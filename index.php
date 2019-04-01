<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

date_default_timezone_set('America/Sao_Paulo');
$page = $_SERVER['PHP_SELF'];

require_once 'php/Produtos.php';
require_once 'php/Compra.php';
require_once 'php/PrintArq.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Lucas Zingaro de Jesus</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="js/script.js" type="text/javascript"></script>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="container">
            <div class="bloco banner"><h1>Compra de Blocos e Tijolos</h1><br><br></div>
            <div class="bloco conteudo">
                <form id="form" name="form"  action="<?php echo $page; ?>" method="POST" onsubmit="return ischeck(this);"s>
                    <br>Nome:  <input type="text" name="nomeCli" value="" size="73%"  required/><br>
                    <br>Cidade:  <input type="text" name="txtCidade" value="" required/>
                    <br><br>Produtos:<br><br>
                    <table border="0" width="100%" cellspacing="1" cellpadding="1">
                        <thead>
                            <tr>
                                <th class="thck"></th>
                                <th>Foto</th>
                                <th>Nome</th>
                                <th>Preço Unitário</th>
                                <th>Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $index = 0;
                            foreach (Produtos::getTodos() as $produto) {
                                echo "<tr>
                                <td width='10px' ><input id='ck".$index."' value='".$index."' class='ck' type='checkbox' name='checkP[]'/></td>
                                <td><img width='200px' src='$produto->img'/></td>
                                <td>$produto->nome</td>
                                <td>R$" . number_format($produto->valor, 2, ",", ".") . "</td>
                                <td><input type='number' name='qtd$index' value='1' onkeypress='return event.charCode >= 48' min='1' /></td>
                            </tr>";
                                $index++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <br><br>
                    <h3>Tempo de Validade:</h3>
                    <br><input type="radio" name="qtdValidade" value="15" required checked="checked"/> 15 dias
                    <br><input type="radio" name="qtdValidade" value="30" required /> 30 dias
                    <br><input type="radio" name="qtdValidade" value="60" required /> 60 dias
                    <br><input type="radio" name="qtdValidade" value="61" required /> Outro - Tempo de Validade em dias: 
                    <input type="number" name="qtdNumValidade" value="1" onkeypress="return event.charCode >= 48" min="0" />
                    <br><br>
                    Desconto: R$<input type="number" name="desconto" value="0"  step="0.01" value="0.00" onkeypress="return event.charCode >= 48" min="0" />
                    <br><br>
                    <br><input class="btn" type="submit" name="btn" value="Confirmar" />
                    <input id="reset" class="btn" type="reset"><br> 

                </form>
            </div> 
            <div class="bloco rodape">
                <form name="backs" action="<?php echo $page; ?>" method="POST">
                    <input class="btn" type="submit" name="btn2" value="Compras anteriores"/>
                </form>
            </div>
        </div>
    </body>
</html>

<?php
$Compra = new Compra();
if (isset($_POST['btn2'])) {
    echo '<div class="compras">' . PrintArq::RecuperarCompras() . '</div>';
    return;
}
if (isset($_POST['btn'])) {
    try {
        if ($_POST['qtdValidade'] > 60) {
            $validade = $_POST['qtdNumValidade'];
        } else {
            $validade = $_POST['qtdValidade'];
        }
        $TodosProdutos = Produtos::getAllToArray();


        $Compra = new Compra();

        $Compra->data = date("d/m/Y - H:i:s");
        $Compra->cidade = $_POST['txtCidade'];
        $Compra->nomeCliente = $_POST['nomeCli'];

        $valorCompra = 0;
        $produtos = [];
        if (isset($_POST['checkP']) && !empty($_POST['checkP'])) {
            $checkP = $_POST['checkP'];
            $N = count($checkP);
            for ($i = 0; $i < $N; $i++) {
                $nomeP = $TodosProdutos[$checkP[$i]]->nome; //nome 
                $valorP = $TodosProdutos[$checkP[$i]]->valor; //valor uni
                $qtdP = $_POST[("qtd$checkP[$i]")]; //quantidade
                $totalP = $valorP * $qtdP; //total produto
                $valorCompra += $totalP;
                array_push($produtos, Compra::getStrProd($nomeP, $valorP, $qtdP, $totalP));
            }

            $Compra->produtos = $produtos;
            $desconto = $_POST['desconto'];
            $Compra->setDesconto($desconto);
            $Compra->setValor(($valorCompra - $desconto));

            $Compra->validade = date("d/m/Y - H:i:s", strtotime(date("") . " + $validade days"));
            $srlC = serialize($Compra);
            echo "<div class='compras'".nl2br(PrintArq::salvarCompra($srlC))."</div>";
        }
    } catch (Exception $e) {
        echo "<br> Erro:$e";
    }
}
?>


