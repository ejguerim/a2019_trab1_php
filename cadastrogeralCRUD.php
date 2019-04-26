
<?php
session_start();
if(session_id()== null || !isset($_SESSION['nome']) ) {
    die('Usuário não logado!');
}

require_once "menu.html";
require_once "conexao2.php";
require_once "funcoesgeral.php";
require_once "funcoeslistas.php";


$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
$atualizarID = filter_input(INPUT_GET, 'AtualizarID', FILTER_VALIDATE_INT);
$deletarID = filter_input(INPUT_GET, 'DeletarID', FILTER_VALIDATE_INT);

//echo '$atualizarID: '.$atualizarID.'<br>';
//echo '$deletarID: '.$deletarID.'<br>';
//echo '$action: '.$action.'<br>';


// APRESENTACAO DO FORM DE CADASTRO E LISTAGENS
if(empty($atualizarID) && empty($deletarID) && empty($action)) {

    cadastrogeralFORM();
    listarcadgeral1($pdo);

}


// ACAO DE CADASTRAR
//
if(empty($atualizarID) && empty($deletarID) && $action== 'Cadastrar') {
    $tipocadastro = filter_input(INPUT_POST, 'tipocadastro', FILTER_SANITIZE_STRING);
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $inscricao = filter_input(INPUT_POST, 'inscricao', FILTER_SANITIZE_STRING);
    $iestado = filter_input(INPUT_POST, 'iestado', FILTER_SANITIZE_STRING);
    $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
    $numero = filter_input(INPUT_POST, 'numero', FILTER_VALIDATE_INT);
    $cep = filter_input(INPUT_POST, 'cep', FILTER_VALIDATE_INT);
    $codmunicipio = filter_input(INPUT_POST, 'codmunicipio', FILTER_VALIDATE_INT);


    $insert = "INSERT INTO cadgeral(tipocadastro, nome, inscricao, iestado, endereco, numero, cep, codmunicipio)
                    VALUES('$tipocadastro', '$nome', '$inscricao', '$iestado', '$endereco', '$numero', '$cep', '$codmunicipio');";
    $pdo->exec($insert);

    cadastrogeralFORM();
    listarcadgeral1($pdo);
}


// ACAO PARA APAGAR
//
if(empty($atualizarID) && !empty($deletarID) && empty($action)) {
    $comandoSQL = "delete from cadgeral where id = $deletarID;";
    $totalapagados = $pdo->exec($comandoSQL);
    echo 'Apagados:' . $totalapagados . '<br>';

    cadastrogeralFORM();
    listarcadgeral1($pdo);

}


// ACAO PARA ABRIR FORMULARIO EDICAO
//
if(!empty($atualizarID) && empty($deletarID) && empty($action)) {
    $consulta = $pdo->query("SELECT * FROM cadgeral WHERE id = $atualizarID;");
    $cadgeral = $consulta->fetchAll(PDO::FETCH_ASSOC);
    if(is_array($cadgeral) && count($cadgeral)>0) {
        $id = $cadgeral[0]['id'];
        $nome = $cadgeral[0]['nome'];
        $tipocadastro = $cadgeral[0]['tipocadastro'];
        $inscricao = $cadgeral[0]['inscricao'];
        $iestado = $cadgeral[0]['iestado'];
        $endereco = $cadgeral[0]['endereco'];
        $numero = $cadgeral[0]['numero'];
        $cep = $cadgeral[0]['cep'];
        $codmunicipio = $cadgeral[0]['codmunicipio'];

        cadastrogeralFORMatualizar($id, $nome, $tipocadastro, $inscricao, $iestado, $endereco, $numero, $cep, $codmunicipio);

    }
    listarcadgeral1($pdo);
}


// ACAO DE ATUALIZACAO UPDATE
//
if(!empty($atualizarID) && empty($deletarID) && $action=='Atualizar') {

    $tipocadastro = filter_input(INPUT_POST, 'tipocadastro', FILTER_SANITIZE_STRING);
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $inscricao = filter_input(INPUT_POST, 'inscricao', FILTER_SANITIZE_STRING);
    $iestado = filter_input(INPUT_POST, 'iestado', FILTER_SANITIZE_STRING);
    $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
    $numero = filter_input(INPUT_POST, 'numero', FILTER_VALIDATE_INT);
    $cep = filter_input(INPUT_POST, 'cep', FILTER_VALIDATE_INT);
    $codmunicipio = filter_input(INPUT_POST, 'codmunicipio', FILTER_VALIDATE_INT);

    $comandoAtualizar = "UPDATE cadgeral SET 
                         nome = '$nome',
                         inscricao = '$inscricao',
                         tipocadastro = '$tipocadastro',
                         iestado = '$iestado',
                         endereco = '$endereco',
                         numero = '$numero',
                         cep = '$cep',
                         codmunicipio = '$codmunicipio'
                         WHERE id = $atualizarID;";
    $pdo->exec($comandoAtualizar);

    cadastrogeralFORM();
    listarcadgeral1($pdo);
}

require_once "rodape.php";



