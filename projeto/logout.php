<?php require_once("../conexao/conexao.php"); ?>
<?php
    // iniciar a sessão
    session_start();
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Curso PHP FUNDAMENTAL</title>
    <!-- estilo -->
    <link href="_css/estilo.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <header>
        <div id="header_central">
            <img src="">
            <img src="">
        </div>
    </header>
    <main> 
        <?php
            // Exclue a variavel de sessao mencionada.
            unset($_SESSION["usuario"]);
            // Destrói todas as variáveis de sessão da app.
            session_destroy(); 
        ?>
    </main>
    <footer>
        <div id="footer_central">
            <p>Evolução Esportes - 2019</p>
        </div>
    </footer>
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
