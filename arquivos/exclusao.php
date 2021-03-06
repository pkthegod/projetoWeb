<?php require_once("../conexao/conexao.php"); ?>
<?php

    // teste de segurança
    session_start();
    if ( !isset($_SESSION["user_portal"]) ) {
        header("location:login.php");
    }
    // fim do teste de seguranca
    
    if( isset($_POST["nomeproduto"]) ) {
        $produtoid = $_POST["produtoID"];
        
        $exclusao = "DELETE FROM produtos ";
        $exclusao .= "WHERE produtoID = $produtoid ";
        $con_exclusao = mysqli_query($conecta,$exclusao);
        if(!$con_exclusao) {
            die("Registro não excluído");
        } else {
            header("location:listagem.php");   
        }
    }

    
    
     // Consulta a tabela de produtos
    $pd = "SELECT * ";
    $pd .= "FROM produtos JOIN fornecedores ON produtos.fornecedorid = fornecedores.fornecedorID ";
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
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">     
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Exclusão de Itens</title>
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/alteracao.css" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php include_once("_incluir/topo.php"); ?>
        <main>  
            <div id="janela_formulario">
                <form action="exclusao.php" method="post">
                    <h2>Exclusão de Produtos</h2>
                    <label for="nomeproduto">Nome do Produto</label>
                    <input type="text" value="<?php echo utf8_encode($info_produtos["nomeproduto"])  ?>" name="nomeproduto" id="nomeproduto">

                    <label for="codigobarra">Código de Barra</label>
                    <input type="text" value="<?php echo utf8_encode($info_produtos["codigobarra"])  ?>" name="codigobarra" id="codigobarra">
                    
                    <label for="precounitario">Preço Unitário</label>
                    <input type="text" value="<?php echo utf8_encode($info_produtos["precounitario"])  ?>" name="precounitario" id="precounitario">
                    
                    <label for="estoque">Estoque</label>
                    <input type="text" value="<?php echo utf8_encode($info_produtos["estoque"])  ?>" name="estoque" id="estoque">
                    
                    <label for="fornecedor">Estoque</label>
                    <input type="text" value="<?php echo utf8_encode($info_produtos["nomefornecedor"])  ?>" name="fornecedor" id="fornecedor">

                    <input type="hidden" name="produtoID" value="<?php echo $info_produtos["produtoID"] ?>">
                    <input type="submit" value="Confirmar exclusão">                    
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