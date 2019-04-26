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


// APRESENTACAO DO FORM DE CADASTRO E LISTAGENS
if(empty($atualizarID) && empty($deletarID) && empty($action)) {

    listarcabdocumento1($pdo);
    cabdocumentoFORM($pdo);

}


// ACAO DE CADASTRAR
//
if(empty($atualizarID) && empty($deletarID) && $action== 'Cadastrar') {

    $tipomov = filter_input(INPUT_POST, 'tipomov', FILTER_SANITIZE_STRING);
    $modelodoc = filter_input(INPUT_POST, 'modelodoc', FILTER_SANITIZE_STRING);
    $numerodoc = filter_input(INPUT_POST, 'numerodoc', FILTER_VALIDATE_INT);
    $seriedoc = filter_input(INPUT_POST, 'seriedoc', FILTER_SANITIZE_STRING);
    $valort = filter_input(INPUT_POST, 'valort', FILTER_SANITIZE_STRING);
    $idcad = filter_input(INPUT_POST, 'idcad', FILTER_VALIDATE_INT);
    $datamov = filter_input(INPUT_POST, 'datamov', FILTER_SANITIZE_STRING);

    $insert = "INSERT INTO cabdocumento(tipomov, modelodoc, numerodoc, seriedoc, valort, idcad, datamov)
                    VALUES( '$tipomov', '$modelodoc', '$numerodoc', '$seriedoc', '$valort', '$idcad', '$datamov');";
    $pdo->exec($insert);

    listarcabdocumento1($pdo);
    cabdocumentoFORM($pdo);
}


// ACAO PARA APAGAR
//
if(empty($atualizarID) && !empty($deletarID) && empty($action)) {
    $comandoSQL = "delete from cabdocumento where lc = $deletarID;";
    $totalapagados = $pdo->exec($comandoSQL);
    echo 'Apagados:' . $totalapagados . '<br>';

    listarcabdocumento1($pdo);
    cabdocumentoFORM($pdo);

}


// ACAO PARA ABRIR FORMULARIO EDICAO
//
if(!empty($atualizarID) && empty($deletarID) && empty($action)) {

    $consulta = $pdo->query("SELECT * FROM cabdocumento WHERE lc = $atualizarID;");
    $cadgeral = $consulta->fetchAll(PDO::FETCH_ASSOC);

    if(is_array($cadgeral) && count($cadgeral)>0) {
        $lc = $cadgeral[0]['lc'];
        $tipomov = $cadgeral[0]['tipomov'];
        $modelodoc = $cadgeral[0]['modelodoc'];
        $numerodoc = $cadgeral[0]['numerodoc'];
        $seriedoc = $cadgeral[0]['seriedoc'];
        $valort = $cadgeral[0]['valort'];
        $idcad = $cadgeral[0]['idcad'];
        $datamov = $cadgeral[0]['datamov'];
//        echo '<pre>' . print_r($cadgeral, true). "</pre><br>";
//        die('--------------');
        cabdocumentoFORMatualizar($pdo, $lc, $tipomov, $modelodoc, $numerodoc, $seriedoc, $valort, $idcad, $datamov);

    }
    listarcabdocumento1($pdo);
}


// ACAO DE ATUALIZACAO UPDATE
//
if(!empty($atualizarID) && empty($deletarID) && $action=='Atualizar') {

    $tipomov = filter_input(INPUT_POST, 'tipomov', FILTER_DEFAULT);
    $modelodoc = filter_input(INPUT_POST, 'modelodoc', FILTER_DEFAULT);
    $numerodoc = filter_input(INPUT_POST, 'numerodoc', FILTER_DEFAULT);
    $seriedoc = filter_input(INPUT_POST, 'seriedoc', FILTER_DEFAULT);
    $valort = filter_input(INPUT_POST, 'valort', FILTER_DEFAULT);
    $idcad = filter_input(INPUT_POST, 'idcad', FILTER_VALIDATE_INT);
    $datamov = filter_input(INPUT_POST, 'datamov', FILTER_DEFAULT);


    $comandoAtualizar = "UPDATE cabdocumento SET 
                         tipomov = '$tipomov',
                         modelodoc = '$modelodoc',
                         numerodoc = '$numerodoc',
                         seriedoc = '$seriedoc',
                         valort = '$valort',
                         idcad = '$idcad',
                         datamov = '$datamov'
                         WHERE lc = $atualizarID;";
    $pdo->exec($comandoAtualizar);

    listarcabdocumento1($pdo);
    cabdocumentoFORM($pdo);
}

require_once "rodape.php";
