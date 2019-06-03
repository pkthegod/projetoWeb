<?php require_once("../conexao/conexao.php"); ?>
<?php
    // teste de segurança
    session_start();
    if ( !isset($_SESSION["user_portal"]) ) {
        header("location:login.php");
    }
    // fim do teste de seguranca
    // insercao no banco
    if(isset($_POST["nomeproduto"])) {
        $nomeproduto       = utf8_decode($_POST["nomeproduto"]);
        $codigobarra   = utf8_decode($_POST["codigobarra"]);
        $precounitario    = utf8_decode($_POST["precounitario"]);
        $estoque     = $_POST["estoque"];
        $fornecedor       = $_POST["fornecedor"];
        
        $inserir    = "INSERT INTO `produtos` (`nomeproduto`, `codigobarra`, `precounitario`, `estoque`, `fornecedorid`) VALUES ('$nomeproduto', '$codigobarra', '$precounitario', '$estoque', '$fornecedor') ";
        
        $operacao_inserir = mysqli_query($conecta,$inserir);
        if(!$operacao_inserir) {
            die("Erro no banco");
        } else {
            header("location:inserir_produtos.php");   
        }
    }
    // selecao de fornecedores
    $select = "SELECT fornecedorID, nomefornecedor ";
    $select .= "FROM fornecedores ";
    $lista_fornecedores = mysqli_query($conecta, $select);
    if(!$lista_fornecedores) {
        die("Erro no banco");
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Inserir Produtos</title>
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/crud.css" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php include_once("_incluir/topo.php"); ?>
        <main> 
            <div id="">
                <form action="inserir_produtos.php" method="post">
                    <input type="text" name="nomeproduto" placeholder="Nome do Produto">
                    <input type="text" name="codigobarra" placeholder="Código de Barra">
                    <input type="text" name="precounitario" placeholder="Preço Unitário">
                    <input type="text" name="estoque" placeholder="Estoque">
                    <select name="fornecedor">
                        <?php
                            while($linha = mysqli_fetch_assoc($lista_fornecedores)) {
                        ?>
                            <option value="<?php echo $linha["fornecedorID"];  ?>">
                                <?php echo utf8_encode($linha["nomefornecedor"]);  ?>
                            </option>
                        <?php
                            }
                        ?>                        
                    </select>
                    <input type="submit" value="inserir">
                </form>
            </div>
        </main>
        <?php include_once("_incluir/rodape.php"); ?>  
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>