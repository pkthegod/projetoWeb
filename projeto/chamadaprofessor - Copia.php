<?php require_once("../conexao/conexao.php"); ?>

<?php
    // teste de segurança
    session_start();
    if ( !isset($_SESSION["user_portal"]) ) {
        header("location:loginprofessor.php");
    }
    // fim do teste de seguranca
    // Determinar localidade BR
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
    $professorid = $_SESSION["user_portal"];
    //consulta a tabela alunosturmamodalidades, turmamodalidade, turmas, diasemana, horarios e alunos
    $diasemanaatual = date("N");
    $consultapchamada = "SELECT * FROM alunos_turmamodalidade atm JOIN turmamodalidades tmd ON atm.turmamodalidadeID = tmd.turmamodalidadesID JOIN turmas tm ON tmd.turmaid = tm.turmaID JOIN diasemana ds ON tm.diasemana = ds.diaID JOIN horarios hrs ON tm.horario = hrs.horarioid JOIN alunos ON atm.alunoID = alunos.alunoID WHERE tmd.professorid = {$professorid} AND ds.diaID = {$diasemanaatual} ";
    $resultadopchamada = mysqli_query($conecta, $consultapchamada);
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
    <?php include_once("_incluir/topoprofessor.php"); ?>
    <main>
        <div class="vertical-menu">
            <a href="turmasprofessor.php" class="active">Turmas</a>
            <a href="chamadaprofessor.php">Chamadas</a>
            <a href="#">Calendário</a>
            <a href="#">Boletos</a>
        </div> 
        <p>Data:<?php echo date('d/m/Y') ?> </p>
        <?php
            if(!$resultadopchamada) {
                echo "Não há turmas";   
            }else{
        ?>
        <div id="janela_formulario"> 
            <form action="chamadaprofessor.php" method="post">
            <table border="1">
                <tr>
                    <th>Aluno(a)</th>
                    <th>Presente?</th> 
                    <th>Desempenho</th>
                </tr>
                    <?php
                        //Conta a quantidade de registros
                    $consultaregistros = "SELECT atm.alunoID FROM alunos_turmamodalidade atm JOIN turmamodalidades tmd ON atm.turmamodalidadeID = tmd.turmamodalidadesID JOIN turmas tm ON tmd.turmaid = tm.turmaID JOIN diasemana ds ON tm.diasemana = ds.diaID JOIN horarios hrs ON tm.horario = hrs.horarioid JOIN alunos ON atm.alunoID = alunos.alunoID WHERE tmd.professorid = {$professorid} AND ds.diaID = {$diasemanaatual} ";
                    $resultadoregistros = mysqli_query($conecta, $consultaregistros);

                    $totalregistros = mysqli_num_rows($resultadoregistros);
                    while($linha = mysqli_fetch_assoc($resultadopchamada)) {
                        $presenca = "presenca" . $linha["alunoID"]; 
                        $desempenho = "desempenho" . $linha["alunoID"];
                    ?>
                <tr>
                    <td>
                        <span> <?php echo utf8_encode($linha["nomealuno"])  ?></span>
                        <input type="hidden" value="<?php echo utf8_encode($linha["alunoturmamodalidadeID"])  ?>" name="aluno" id="aluno" readonly="readonly"  ?>
                    </td>
                    <td>
                        <input type="radio" name="<?php echo $presenca ;  ?>" value="1">SIM
                        <input type="radio" name="<?php echo $presenca; ?>" value="0"> NÃO 
                    </td>
                    <td>
                        <input type="radio" name="<?php echo $desempenho; ?>" value="1">Bom 
                        <input type="radio" name="<?php echo $desempenho ;?>" value="2">Muito Bom
                        <input type="radio" name="<?php echo $desempenho ;?>" value="3"> Ótimo 
                        <input type="radio" name="<?php echo $desempenho ;?>" value="4"> Excelente 
                        <input type="radio" name="<?php echo $desempenho ;?>" value="5"> Perfeito           
                    </td>
                  </tr>
                <?php
                $alunoid = $linha["alunoID"];         
                ?>
                <input type="hidden" value="<?php echo date('Y-m-d')  ?>" name="dataatual" id="dataatual" readonly="readonly"  ?>
                <?php
                    }
                ?> 
                </table> 
                <input type="submit" value="Confirmar"> 
            </form>
        </div>
        <?php
            }
        ?>
    </main>
    <?php include_once("_incluir/rodape.php"); ?>  
    <?php
        if( isset($_POST["aluno"]) ) {
            $alunomodalidadeid = $_POST["aluno"];
            $data        = $_POST["dataatual"];
            $presencaid       = $_POST[$presenca];
            $desempenhoid   = $_POST[$desempenho];

            $inserir    = "INSERT INTO chamadas ";
            $inserir    .= "(alunoturmamodalidade_id,dataatual,presenca,desempenho) ";
            $inserir    .= "VALUES ";
            $inserir    .= "('$alunomodalidadeid','$data','$presencaid', '$desempenhoid')";

            $operacao_inserir = mysqli_query($conecta,$inserir);
            if(!$operacao_inserir) {
            die("Erro no banco");
            } 
        }
    ?>
</body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>