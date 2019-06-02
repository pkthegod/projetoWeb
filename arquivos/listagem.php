<?php require_once("../conexao/conexao.php"); ?>

<?php
    // teste de segurança
    session_start();
    if ( !isset($_SESSION["user_portal"]) ) {
        header("location:login.php");
    }
    // fim do teste de seguranca

    // Determinar localidade BR
    setlocale(LC_ALL, 'pt_BR');

    // Consulta ao banco de dados
    $produtos = "SELECT * FROM `produtos` JOIN fornecedores ON produtos.fornecedorid = fornecedores.fornecedorID ";
    
    if ( isset($_GET["produto"]) ) {
        $nome_produto = $_GET["produto"];
        $produtos .= "WHERE nomeproduto LIKE '%{$nome_produto}%' ";
    }
    $resultado = mysqli_query($conecta, $produtos);
    if(!$resultado) {
        die("Falha na consulta ao banco");   
    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Projeto</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/produtos.css" rel="stylesheet">
        <link href="_css/produto_pesquisa.css" rel="stylesheet">
    </head>

    <body>
        <?php include_once("_incluir/topo.php"); ?>
        
        <main>
            <div id="janela_pesquisa">
                <form action="listagem.php" method="get">
                    <input type="text" name="produto" placeholder="Pesquisa">
                    <input type="image"  src="assets/botao_search.png">
                </form>
            </div>
            
            <div id="listagem_produtos"> 
            <?php
                while($linha = mysqli_fetch_assoc($resultado)) {
            ?>
                <ul>
                    
                    <li><h3><?php echo utf8_encode($linha["nomeproduto"]) ?></h3></li>
                    <li>Código de Barra :<?php echo $linha["codigobarra"] ?></li>
                    <li>Pre&ccedil;o Unit&aacute;rio : <?php echo number_format($linha["precounitario"],2, '.', '') ?></li>
                    <li>Estoque : <?php echo $linha["estoque"] ?></li>
                    <li>Fornecedor: <?php echo $linha["nomefornecedor"] ?> </li>
                     <a href="alteracao.php?codigo=<?php echo $linha["produtoID"] ?>">Alterar</a>    
                     <a href="exclusao.php?codigo=<?php echo $linha["produtoID"] ?>">Excluir</a> 
                    
                </ul>
             <?php
                }
            ?> 
                
            
                
                
            </div>
            
        </main>

        <?php include_once("_incluir/rodape.php"); ?>  
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>