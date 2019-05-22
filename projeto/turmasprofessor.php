<?php require_once("../conexao/conexao.php"); ?>

<?php
    // teste de segurança
    session_start();
    if ( !isset($_SESSION["user_portal"]) ) {
        header("location:loginprofessor.php");
    }
    // fim do teste de seguranca
    // Determinar localidade BR
    setlocale(LC_ALL, 'pt_BR');
    $professorid = $_SESSION["user_portal"];
    //consulta a tabela turmamodalidades, turmas, dia semana, horários , modalidade.
    $consultatm = "SELECT * FROM turmamodalidades tmd JOIN turmas tm ON tmd.turmaid = tm.turmaID JOIN diasemana ds ON tm.diasemana = ds.diaID JOIN horarios hrs ON tm.horario = hrs.horarioid JOIN modalidades md ON tmd.modalidadeid = md.modalidadeID  WHERE tmd.professorid = {$professorid} ORDER BY ds.diaID ASC ";

    $resultadotm = mysqli_query($conecta, $consultatm);
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
                      <a href="calendarioprofessor.php">Calendário</a>
                      <a href="boletosprofessor.php">Boletos</a>
            </div> 
            <div> 
            <?php
                if(!$resultadotm) {
                    die("Não há turmas");   
                }
            ?>
                <table border="12">
                      <tr>
                        <th>Modalidade</th>
                        <th>Dia da Semana</th> 
                        <th>Horário</th>
                      </tr>
                           <?php
                         while ($dadostm = mysqli_fetch_assoc($resultadotm)){
                    ?>
                      <tr>
                        <td>
                          <?php
                            echo utf8_encode($dadostm["nomemodalidade"]);       ?></td>
                            <td><?php
                                echo utf8_encode($dadostm["dia"]);      ?>
                             </td>
                            <td >
                          <?php
                             echo  $dadostm["horarioinicial"] . " " . "às" . " " . $dadostm["horariofinal"];  
                             ?>
                             </td>
                      </tr>
                      <?php 
                         }
                        ?>
                    </table>
            </div>
        </main>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
        <?php include_once("_incluir/rodape.php"); ?>  
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
