<?php

session_start();
if(session_id()== null || !isset($_SESSION['nome']) ) {
    die('Usuário não logado!');
}

require_once "menu.html";
require_once "conexao2.php";
?>

<html>
<body>

<link rel="stylesheet" type="text/css" href="./css/estilo.css">

<form method="post">
    CADASTRO<BR>
    Novo Usuário:<input type="text" name="nome"/><br>
    Senha:<input type="password" name="senha"/><br>
    <input type="submit" name="action" value="Cadastrar"/>
</form>
</body>
</html>

<?php

$senhaAberta = filter_input(INPUT_POST,'senha',FILTER_DEFAULT);
if (!is_null($senhaAberta)) {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_DEFAULT);
    $senhaParaArmazenarNoBanco =  password_hash($senhaAberta, PASSWORD_DEFAULT);

    $sql = "insert into usuarios(nome, senha) " .
           "VALUE('$nome', '$senhaParaArmazenarNoBanco');";
    $pdo->exec($sql);
}

require_once "rodape.php";

?>
