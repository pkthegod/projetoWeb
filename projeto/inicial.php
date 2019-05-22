<!DOCTYPE html>
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
            <img src="assets/logo_andes.gif">
            <img src="assets/text_bnwcoffee.gif">
        </div>
    </header>
    <main>
        <?php
            $valores = range( 1 , 10 );
            $sql = sprintf( 'INSERT INTO tabela(numero) VALUES (%s)', implode( '), (' , $valores ) );

            echo $sql;

            $a1 = array("1","2","3");
            $a2 = array("a");
            $a3 = array();

            echo "a1 is: '".implode("','",$a1)."'<br>";
            echo "a2 is: '".implode("','",$a2)."'<br>";
            echo "a3 is: '".implode("','",$a3)."'<br>";

            $a = "oi";
            $i = 1;

            while ($i <= 2 ){
                $c[] = $a . $i; 
                $i++;
            }

            print_r ($c);
            $array = array('lastname', 'email', 'phone');
            $comma_separated = implode(",", $array);

            print $comma_separated; // lastname,email,phone
        ?>
    </main>
    <footer>
        <div id="footer_central">
        </div>
    </footer>
</body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
