<?php require_once("../conexao/conexao.php"); ?>

<?php
    // teste de segurança
    session_start();
    if ( !isset($_SESSION["user_portal"]) ) {
        header("location:loginaluno.php");
    }
    // fim do teste de seguranca
    // Determinar localidade BR
    setlocale(LC_ALL, 'pt_BR');
    $alunoid = $_SESSION["user_portal"];
    //consulta a tabela alunosmodalidades
    $alunosmodalidades = "SELECT * FROM alunos_turmamodalidade WHERE alunoID = {$alunoid} ";

    $resultadoaluno = mysqli_query($conecta, $alunosmodalidades);
    
    if(!$resultadoaluno) {
        die("Falha na consulta ao banco");   
    }
    $dados_alunomodalidade = mysqli_fetch_assoc($resultadoaluno);

    $turmaaluno = $dados_alunomodalidade["turmamodalidadeID"];
    // Consulta a tabela bilhetes
    $bilhete = "SELECT * ";
    $bilhete .= "FROM bilhetes WHERE turma_alunos = {$turmaaluno} ";
    
    $resultadobilhete = mysqli_query($conecta, $bilhete);
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Evolução</title>
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/produtos.css" rel="stylesheet">
        <link href="_css/produto_pesquisa.css" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    </head>
    <body>
        <?php include_once("_incluir/topo.php"); ?>
        <main>
             <div class="vertical-menu">
                      <a href="bilhetes.php" class="active">Bilhetes</a>
                      <a href="frequencia.php">Frequência</a>
                      <a href="#">Calendário</a>
                      <a href="#">Boletos</a>
              </div> 
            <div id="listagem_produtos"> 
            <?php
                if(empty($resultadobilhete)) {
                    die( "Não há bilhetes");   
                }
                while($linha = mysqli_fetch_assoc($resultadobilhete)) {
            ?>
                <ul>
                    <li><h3>Assunto:<?php echo utf8_encode($linha["nomebilhete"]) ?></h3> </li>
                    <li><?php echo utf8_encode($linha["recado"]) ?></li>
                    <li>Data da Publicação : <?php echo date('d/m/Y H:i:s', strtotime($linha["data"])); ?></li>
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
