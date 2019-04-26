<?php

require_once "indexlog.html";
require_once "conexao2.php";

$senhaAberta = filter_input(INPUT_POST,'senha',FILTER_DEFAULT);

if (!is_null($senhaAberta)) {
    $nome = filter_input(INPUT_POST,
        'nome',
        FILTER_DEFAULT);

    $consultar = $pdo->query("select COUNT(*) as total_rows from usuarios");
    $usuarior = $consultar->fetchAll(PDO::FETCH_ASSOC);
    
    $nr = $usuarior[0]['total_rows'];

    $consulta = $pdo->query("select * from usuarios where nome = '$nome'");
    $usuario = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
    echo 'Nr de registros: '.$nr;
    
    if($nr == 0) {
            session_start();
            $_SESSION['nome'] = 'Primeiro acesso';
            header('Location: menu.html');
            die();
    } else {

     if(isset($usuario[0])) {
        $logou = password_verify($senhaAberta, $usuario[0]['senha'] );
        if ($logou) {
            session_start();
            $_SESSION['nome'] = $usuario[0]['nome'];
            header('Location: menu.html');
            die();
        } else {
            $mensagem =  'Senha inválida.';
        }
     } else {
        $mensagem = 'Usuário não encontrado!';
     }
    }
}
?>
<html>
<body>
<form method="post">
    Entrar no Sistema<br>
    Usuário:<input type="text" name="nome"/><br>
    Senha:<input type="password" name="senha"/><br>
    <input type="submit" name="action" value="Login"/>
</form>
<?php echo isset($mensagem)?$mensagem:''; ?>

</body>
</html>

<?php
require_once "rodape.php";
?>
