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
$lccab = filter_input(INPUT_GET, 'lccab', FILTER_VALIDATE_INT);
$deletarID = filter_input(INPUT_GET, 'DeletarID', FILTER_VALIDATE_INT);


// APRESENTACAO DO FORM DE CADASTRO E LISTAGENS
if(empty($atualizarID) && empty($deletarID) && empty($action)) {

    listarmovitens1($pdo, $lccab);
    movitensFORM($pdo, $lccab);

}


// ACAO DE CADASTRAR
//
if(empty($atualizarID) && empty($deletarID) && $action== 'Cadastrar') {

    $lccab = filter_input(INPUT_POST, 'lccab', FILTER_DEFAULT);
    $lote = filter_input(INPUT_POST, 'lote', FILTER_DEFAULT);
    $cfop = filter_input(INPUT_POST, 'cfop', FILTER_DEFAULT);
    $qtd = filter_input(INPUT_POST, 'qtd', FILTER_DEFAULT);
    $valorun = filter_input(INPUT_POST, 'valorun', FILTER_DEFAULT);
    $valort = filter_input(INPUT_POST, 'valort', FILTER_DEFAULT);
    $iditem = filter_input(INPUT_POST, 'iditem', FILTER_DEFAULT);

    $insert = "INSERT INTO movitens(lccab, lote, cfop, qtd, valorun, valort, iditem)
                    VALUES( '$lccab', '$lote', '$cfop', '$qtd', '$valorun', '$valort', '$iditem');";

    $pdo->exec($insert);

    listarmovitens1($pdo, $lccab);
    movitensFORM($pdo, $lccab);
}


// ACAO PARA APAGAR
//
if(empty($atualizarID) && !empty($deletarID) && empty($action)) {
    $comandoSQL = "delete from movitens where lc = $deletarID;";
    $totalapagados = $pdo->exec($comandoSQL);
    echo 'Apagados:' . $totalapagados . '<br>';

    listarmovitens1($pdo, $lccab);
    movitensFORM($pdo, $lccab);

}


// ACAO PARA ABRIR FORMULARIO EDICAO
//
if(!empty($atualizarID) && empty($deletarID) && empty($action)) {

    $consulta = $pdo->query("SELECT * FROM movitens WHERE lc = $atualizarID;");
    $movitensArray = $consulta->fetchAll(PDO::FETCH_ASSOC);

    if(is_array($movitensArray) && count($movitensArray)>0) {
        $lc = $movitensArray[0]['lc'];
        $lccab = $movitensArray[0]['lccab'];
        $lote = $movitensArray[0]['lote'];
        $cfop = $movitensArray[0]['cfop'];
        $qtd = $movitensArray[0]['qtd'];
        $valorun = $movitensArray[0]['valorun'];
        $valort = $movitensArray[0]['valort'];
        $iditem = $movitensArray[0]['iditem'];

        movitensFORMatualizar($pdo, $lc, $lote, $cfop, $qtd, $valorun, $valort, $iditem, $lccab);

    }

    listarmovitens1($pdo, $lccab);
}


// ACAO DE ATUALIZACAO UPDATE
//
if(!empty($atualizarID) && empty($deletarID) && $action=='Atualizar') {


    $lc = filter_input(INPUT_POST, 'lc', FILTER_DEFAULT);
    $lccab = filter_input(INPUT_POST, 'lccab', FILTER_DEFAULT);
    $lote = filter_input(INPUT_POST, 'lote', FILTER_DEFAULT);
    $cfop = filter_input(INPUT_POST, 'cfop', FILTER_DEFAULT);
    $qtd = filter_input(INPUT_POST, 'qtd', FILTER_DEFAULT);
    $valorun = filter_input(INPUT_POST, 'valorun', FILTER_DEFAULT);
    $valort = filter_input(INPUT_POST, 'valort', FILTER_DEFAULT);
    $iditem = filter_input(INPUT_POST, 'iditem', FILTER_DEFAULT);

    echo 'LC: '.$lc;
    echo 'LC cab: '.$lccab;

    $comandoAtualizar = "UPDATE movitens SET 
                         lote = '$lote',
                         cfop = '$cfop',
                         qtd = '$qtd',
                         valorun = '$valorun',
                         valort = '$valort',
                         iditem = '$iditem'
                         WHERE lc = $atualizarID;";
    $pdo->exec($comandoAtualizar);

    listarmovitens1($pdo, $lccab);
    movitensFORM($pdo, $lccab);

}

require_once "rodape.php";
