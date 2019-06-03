<header>
    <div id="header_central">
        <?php
            if ( isset($_SESSION["user_portal"])  ) {
                $user = $_SESSION["user_portal"];
                
                $saudacao = "SELECT nomecompleto ";
                $saudacao .= "FROM users ";
                $saudacao .= "WHERE userID = {$user} ";
                
                $saudacao_login = mysqli_query($conecta,$saudacao);
                if(!$saudacao_login) {
                    die("Falha no banco");   
                }
                
                $saudacao_login = mysqli_fetch_assoc($saudacao_login);
                $nome = $saudacao_login["nomecompleto"];
                
        ?>
            <div id="header_saudacao"><h5>Bem vindo, <?php echo $nome ?> - <a href="logout.php">Sair</a></h5></div>
        <?php
            }
        ?>
        <img src="assets/logo_andes.gif">
        <img src="assets/text_bnwcoffee.gif">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand">Menu</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Alterna navegação">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">                  <a class="nav-item nav-link active" href="./listagem.php">Home <span class="sr-only">(Página atual)</span></a>
                <a class="nav-item nav-link" href="./inserir_produtos.php">Inserir</a>
                <a class="nav-item nav-link" href="./exclusao.php">Deletar</a>
                </div>
            </div>
        </nav>
    </div>
</header>