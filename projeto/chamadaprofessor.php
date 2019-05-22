<?php require_once("../conexao/conexao.php");?>

<?php
    // teste de segurança
    session_start();
    if ( !isset($_SESSION["user_portal"])) {
        header("location:loginprofessor.php");
    }
    // fim do teste de seguranca
    // Determinar localidade BR
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
    $professorid = $_SESSION["user_portal"];
    //consulta a tabela alunosturmamodalidades, turmamodalidade, turmas, diasemana, horarios e alunos
    $diasemanaatual = date("N");
?>
<!DOCTYPE html>
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
    <?php
        include_once("_incluir/topoprofessor.php"); 
    ?>
    <main>
         <div class="vertical-menu">
            <a href="turmasprofessor.php" class="active">Turmas</a>
            <a href="chamadaprofessor.php">Chamadas</a>
            <a href="#">Calendário</a>
            <a href="#">Boletos</a>
        </div> 
        <p>Data:<?php echo date('d/m/Y') ?> </p>
        <?php 
                $consultatmhr = "SELECT DISTINCT hrs.* FROM alunos_turmamodalidade atm JOIN turmamodalidades tmd ON atm.turmamodalidadeID = tmd.turmamodalidadesID JOIN turmas tm ON tmd.turmaid = tm.turmaID JOIN diasemana ds ON tm.diasemana = ds.diaID JOIN horarios hrs ON tm.horario = hrs.horarioid JOIN alunos ON atm.alunoID = alunos.alunoID WHERE tmd.professorid = {$professorid} AND ds.diaID = {$diasemanaatual}";
                $resultadotmhr = mysqli_query($conecta, $consultatmhr);  ?>
        <?php
            if(empty($resultadotmhr)) {
                die ("Não há turmas"); 
                // COLOCAR UM SCRIPT AQUI PARA O OCULTAR O FORM ABAIXO E A TABELA
            }else{
        ?>
        <form name="obterhorario" method="get" >
                <select name="horario">
                    <option value="" selected="selected">Selecione um horário</option>
                    <?php
                        while($linha = mysqli_fetch_assoc($resultadotmhr)) {
                    ?>
                        <option value="<?php echo $linha["horarioid"];  ?>">
                            <?php echo utf8_encode($linha["horarioinicial"]) . " " . "às" . " " . utf8_encode($linha["horariofinal"]);  ?>
                        </option>
                    <?php
                        }
                    ?>                        
                </select>
            <input type="submit" value="Buscar"  />
        </form>
        <?php 
            }
            $horarioselected = " ";
            if( isset($_GET["horario"]) ) {
                $horarioselected = $_GET["horario"];
                $consultapchamada = "SELECT * FROM alunos_turmamodalidade atm JOIN turmamodalidades tmd ON atm.turmamodalidadeID = tmd.turmamodalidadesID JOIN turmas tm ON tmd.turmaid = tm.turmaID JOIN diasemana ds ON tm.diasemana = ds.diaID JOIN horarios hrs ON tm.horario = hrs.horarioid JOIN alunos ON atm.alunoID = alunos.alunoID WHERE tmd.professorid = {$professorid} AND ds.diaID = {$diasemanaatual} AND hrs.horarioid = {$horarioselected} ";
                $resultadopchamada = mysqli_query($conecta, $consultapchamada);
            }
            if(empty($resultadopchamada)){
                die("Não há registros");
            }
        ?>
        <div id="janela_formulario"> 
            <form  method="post">
                <table border="1">
                    <tr>
                        <th>Aluno(a)</th>
                        <th>Presente?</th> 
                        <th>Desempenho</th>
                    </tr>
                    <?php
                    //Conta a quantidade de registros
                    //Consulta Alunos - atm.alunoID  
                    $consultaregistros = "SELECT atm.alunoID FROM alunos_turmamodalidade atm JOIN turmamodalidades tmd ON atm.turmamodalidadeID = tmd.turmamodalidadesID JOIN turmas tm ON tmd.turmaid = tm.turmaID JOIN diasemana ds ON tm.diasemana = ds.diaID JOIN horarios hrs ON tm.horario = hrs.horarioid JOIN alunos ON atm.alunoID = alunos.alunoID WHERE tmd.professorid = {$professorid} AND ds.diaID = {$diasemanaatual} AND hrs.horarioid = {$horarioselected} ";
                    $resultadoregistros = mysqli_query($conecta, $consultaregistros);
                    $totalregistros = mysqli_num_rows($resultadoregistros);

                     while($linha = mysqli_fetch_assoc($resultadopchamada)) {
                        $aluno = "aluno" . $linha["alunoID"]; 
                        $presenca = "presenca" . $linha["alunoID"]; 
                        $desempenho = "desempenho" . $linha["alunoID"];

                        $aaluno[] = $aluno;
                        $apresenca[] = $presenca; 
                        $adesempenho[] = $desempenho;
                    ?>
                    <tr>
                    <td>
                        <span><?php echo utf8_encode($linha["nomealuno"])?></span>
                        <input type="hidden" value="<?php echo utf8_encode($linha["alunoturmamodalidadeID"])?>" name="<?php echo $aluno ?>" id="aluno" readonly="readonly">
                    </td>
                    <td>
                        <input type="radio" name="<?php echo $presenca;?>" value="1">SIM
                        <input type="radio" name="<?php echo $presenca;?>" value="0">NÃO 
                        </td>
                        <td>
                            <input type="radio" name="<?php echo $desempenho;?>" value="1">Bom 
                            <input type="radio" name="<?php echo $desempenho;?>" value="2">Muito Bom
                            <input type="radio" name="<?php echo $desempenho;?>" value="3">Ótimo 
                            <input type="radio" name="<?php echo $desempenho;?>" value="4">Excelente 
                            <input type="radio" name="<?php echo $desempenho;?>" value="5">Perfeito           
                        </td>
                    </tr>
                <input type="hidden" value="<?php echo date('Y-m-d')?>" name="dataatual" id="dataatual" readonly="readonly">
                <?php
                    }
                ?> 
                </table> 
                <input type="submit" value="Confirmar"> 
                <input type="reset" value="Limpar" />
            </form>
        </div>
    </main>
    <?php include_once("_incluir/rodape.php"); ?>  
</body>
<?php
    if( isset($_POST["dataatual"]) ) {
            $i=0;
        while($i < $totalregistros ){
            $alunomodalidadeid[] = $_POST[$aaluno[$i]];
            $data        = $_POST["dataatual"];
            $presencaid[]       = $_POST[$apresenca[$i]];
            $desempenhoid[]   = $_POST[$adesempenho[$i]];
            $i++;    
        }

        $values = '';
        for ($i = 0; $i < $totalregistros; $i++) {
            $values .=  sprintf("('$alunomodalidadeid[$i]', '$data', '$presencaid[$i]', '$desempenhoid[$i]'),");
        }
        //Função utilizada pra remover a última vírgula 
        $values = substr($values, 0, -1);
        echo $values;

        $inserir = "INSERT INTO chamadas ";
        $inserir.= "(alunoturmamodalidade_id,dataatual,presenca,desempenho)VALUES".$values;

        $operacao_inserir = mysqli_query($conecta,$inserir);
        if(!$operacao_inserir) {
            die("Erro no banco");
        }
    }
?>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
