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
    </head>

    <body>
        <header>
            <div id="header_central">
                <img src="assets/logo_andes.gif">
                <img src="assets/text_bnwcoffee.gif">
            </div>
        </header>
        
        <main> 
            <?php
                // Exclue a variavel de sessao mencionada.
                unset($_SESSION["usuario"]);

                // Destrói todas as variáveis de sessão da app.
                session_destroy(); 
                header("location:login.php");
            ?>
            
        </main>

        <footer>
            <div id="footer_central">
                <p>Projeto Salvador</p>
            </div>
        </footer>
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>