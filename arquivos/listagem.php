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
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Lista de Itens</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/produtos.css" rel="stylesheet">
        <link href="_css/produto_pesquisa.css" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
            <div class="col-xl-12">
                <table class="table-responsive table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" colspan="2">Nome do Produto</th>
                            <th scope="col" colspan="2">Código de Barras</th>
                            <th scope="col" colspan="2">Valor Unitário</th>
                            <th scope="col" colspan="2">Estoque</th>
                            <th scope="col" colspan="2">Nome do Fornecedor</th>
                            <th scope="col" colspan="2">Ações</th>
                        </tr>
                    </thead>
                </table>
            <?php
                while($linha = mysqli_fetch_assoc($resultado)) {
            ?>
                <table class="table-responsive table-bordered">
                    <tbody>
                        <tr>
                            <td><?php echo utf8_encode($linha["nomeproduto"]) ?></td>
                            <td><?php echo $linha["codigobarra"] ?></td>
                            <td><?php echo number_format($linha["precounitario"],2, '.', '') ?></td>
                            <td><?php echo $linha["estoque"] ?></td>
                            <td><?php echo $linha["nomefornecedor"] ?> </td>
                            <td>
                                <button>
                                    <a href="alteracao.php?codigo=<?php echo $linha["produtoID"] ?>">Alterar</a>
                                </button><br><br>
                                <button>
                                    <a href="exclusao.php?codigo=<?php echo $linha["produtoID"] ?>">Excluir</a>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
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