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

    //busca o aluno da respectiva turma
    $consultachamada = "SELECT * FROM alunos_turmamodalidade atm JOIN alunos ON atm.alunoID = alunos.alunoID JOIN turmamodalidades tm ON atm.turmamodalidadeID = tm.turmamodalidadesID JOIN professores pf ON tm.professorid = pf.professorID JOIN modalidades md ON tm.modalidadeid = md.modalidadeID JOIN chamadas ON atm.alunoturmamodalidadeID = chamadas.alunoturmamodalidade_id JOIN desempenho ON chamadas.desempenho = desempenho.desempenhoID WHERE alunos.alunoID = {$alunoid} ";



    $resultadochamada = mysqli_query($conecta, $consultachamada);
    
    if(!$resultadochamada) {
        die("Falha na consulta ao banco");   
    }
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
            if(empty($resultadochamada)) {
                echo "Não há registros";   
            }
            while($dadoschamada = mysqli_fetch_assoc($resultadochamada)) {
        ?>
            <ul>
                <li><h3>Modalidade:
                <?php
                    echo $dadoschamada["nomemodalidade"];
                 ?>
                    </h3></li>
                <li>Data :<?php echo date('d/m/Y',strtotime($dadoschamada["dataatual"]))?></li>
                <li>Situação :
                <?php if($dadoschamada["presenca"] == 1){
                    echo "Presente";
                }else{
                    echo "Faltou";
                }?>
                </li>
                <li>Desempenho : <?php  echo $dadoschamada["nomedesempenho"];?></li>
                <li>Professor(a) : 
                    <?php echo $dadoschamada["nomeprofessor"];?>
                </li>
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
