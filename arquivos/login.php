<?php require_once("../conexao/conexao.php"); ?>
<?php
    // adicionar variaveis de sessao
    session_start();

    if ( isset( $_POST["usuario"] )  ) {
        $usuario    = $_POST["usuario"];
        $senha      = $_POST["senha"];    
        
        $login = "SELECT * ";
        $login .= "FROM users ";
        $login .= "WHERE usuario = '{$usuario}' and senha = '{$senha}' ";
    
        $acesso = mysqli_query($conecta, $login);
        if ( !$acesso ) {
            die("Falha na consulta ao banco");
        }
        
        $informacao = mysqli_fetch_assoc($acesso);
        
        if ( empty($informacao) ) {
            $mensagem = "Login sem sucesso.";
        } else {
            $_SESSION["user_portal"] = $informacao["userID"];
            header("location:listagem.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Pagina principal</title>
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/login.css" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
        <header>
            <div id="header_central">
                <img src="assets/logo_andes.gif">
                <img src="assets/text_bnwcoffee.gif">
            </div>
        </header>
        <main>
            <div id="janela_login" class="container">
                <form action="login.php" method="post">
                    <h2>Tela de Login</h2>
                    <input type="text" name="usuario" placeholder="Usuário">
                    <input type="password" name="senha" placeholder="Senha">
                    <input type="submit" value="Login">
                    <?php
                        if ( isset($mensagem)) { 
                    ?>
                        <p><?php echo $mensagem ?></p>
                    <?php
                        }
                    ?>                    
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