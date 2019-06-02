<?php require_once("../conexao/conexao.php"); ?>
<?php

    // teste de segurança
    session_start();
    if ( !isset($_SESSION["user_portal"]) ) {
        header("location:login.php");
    }
    // fim do teste de seguranca


    if( isset($_POST["nomeproduto"]) ) {
        $nome       = utf8_decode($_POST["nomeproduto"]);
        $codigobarra   = $_POST["codigobarra"];
        $precounitario    = $_POST["precounitario"];
        $estoque     = $_POST["estoque"];
        $fID        = $_POST["fornecedorid"];
        $produtoid = $_POST["produtoid"];
        
        // Objeto para alterar
        $alterar = "UPDATE `produtos` SET `nomeproduto` = '$nome', `codigobarra` = '$codigobarra', `precounitario` = '$precounitario', `estoque` = '$estoque', `fornecedorid` = '$fID' WHERE `produtoID` = $produtoid  ";
        
        $operacao_alterar = mysqli_query($conecta, $alterar);
        if(!$operacao_alterar) {
            die("Erro na alteracao");   
        } else {
            header("location:listagem.php");   
        }
        
    }

    // Consulta a tabela de produtos
    $pd = "SELECT * ";
    $pd .= "FROM produtos ";
    if(isset($_GET["codigo"]) ) {
        $id = $_GET["codigo"];
        $pd .= "WHERE produtoID = {$id} ";
    } else {
        $pd .= "WHERE produtoID = 1 ";
    }
    
    $con_produtos = mysqli_query($conecta,$pd);
    if(!$con_produtos) {
        die("Erro na consulta");
    }

    $info_produtos = mysqli_fetch_assoc($con_produtos);

    // consulta aos fornecedores
    $fornecedores = "SELECT * ";
    $fornecedores .= "FROM fornecedores ";
    $lista_fornecedores = mysqli_query($conecta, $fornecedores);
    if(!$lista_fornecedores) {
       die("erro no banco"); 
    }

?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Curso PHP INTEGRACAO</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/alteracao.css" rel="stylesheet">
    </head>

    <body>
        <?php include_once("_incluir/topo.php"); ?>
        
        <main>  
            <div id="janela_formulario">
                <form action="alteracao.php" method="post">
                    <h2>Alteração de Produtos</h2>
                    
                    <label for="nomeproduto">Nome do Produto</label>
                    <input type="text" value="<?php echo utf8_encode($info_produtos["nomeproduto"])  ?>" name="nomeproduto" id="nomeproduto">

                    <label for="codigobarra">Código de Barra</label>
                    <input type="text" value="<?php echo utf8_encode($info_produtos["codigobarra"])  ?>" name="codigobarra" id="codigobarra">
                    
                    <label for="precounitario">Preço Unitário</label>
                    <input type="text" value="<?php echo utf8_encode($info_produtos["precounitario"])  ?>" name="precounitario" id="precounitario">
                    
                    <label for="estoque">Estoque</label>
                    <input type="text" value="<?php echo utf8_encode($info_produtos["estoque"])  ?>" name="estoque" id="estoque">
                    
                    
                    
                    
                    <label for="fornecedorid">Fornecedor</label>
                    <select id="fornecedorid" name="fornecedorid"> 
                        <?php 
                            $meufornecedor = $info_produtos["fornecedorid"];
                            while($linha = mysqli_fetch_assoc($lista_fornecedores)) {
                                $fornecedor_principal = $linha["fornecedorID"];
                                if($meufornecedor == $fornecedor_principal) {
                        ?>
                            <option value="<?php echo $linha["fornecedorID"] ?>" selected>
                                <?php echo utf8_encode($linha["nomefornecedor"]) ?>
                            </option>
                        <?php
                                } else {
                        ?>
                            <option value="<?php echo $linha["fornecedorID"] ?>" >
                                <?php echo utf8_encode($linha["nomefornecedor"]) ?>
                            </option>                        
                        <?php 
                                }
                            }
                        ?>
                    </select>
                    
                    
                    <input type="hidden" name="produtoid" value="<?php echo $info_produtos["produtoID"] ?>">
                    <input type="submit" value="Confirmar alteração">                    
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