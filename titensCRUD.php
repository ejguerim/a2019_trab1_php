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


// APRESENTACAO DO FORM DE ITENS E LISTAGENS
if(empty($atualizarID) && empty($deletarID) && empty($action)) {

    listartitens1($pdo);
    titensFORM();

}


// ACAO DE CADASTRAR
//
if(empty($atualizarID) && empty($deletarID) && $action== 'Cadastrar') {
    $id = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
    $codbarras = filter_input(INPUT_POST, 'codbarras', FILTER_DEFAULT);
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_DEFAULT);
    $unidade = filter_input(INPUT_POST, 'unidade', FILTER_DEFAULT);
    $valorv = filter_input(INPUT_POST, 'valorv', FILTER_DEFAULT);
    $cst = filter_input(INPUT_POST, 'cst', FILTER_DEFAULT);
    $estoque = filter_input(INPUT_POST, 'estoque', FILTER_DEFAULT);


    $insert = "INSERT INTO titens(codbarras, descricao, unidade, valorv, cst, estoque)
                    VALUES('$codbarras', '$descricao', '$unidade', '$valorv', '$cst', '$estoque');";
    $pdo->exec($insert);

    titensFORM();
    listartitens1($pdo);
}


// ACAO PARA APAGAR
//
if(empty($atualizarID) && !empty($deletarID) && empty($action)) {
    
    $comandoSQL = "delete from titens where id = $deletarID;";
    $totalapagados = $pdo->exec($comandoSQL);
    echo 'Apagados:' . $totalapagados . '<br>';

    titensFORM();
    listartitens1($pdo);

}


// ACAO PARA ABRIR FORMULARIO EDICAO
//
if(!empty($atualizarID) && empty($deletarID) && empty($action)) {
    $consulta = $pdo->query("SELECT * FROM titens WHERE id = $atualizarID;");
    $caditens = $consulta->fetchAll(PDO::FETCH_ASSOC);
    if(is_array($caditens) && count($caditens)>0) {
        $id = $caditens[0]['id'];
        $codbarras = $caditens[0]['codbarras'];
        $descricao = $caditens[0]['descricao'];
        $unidade = $caditens[0]['unidade'];
        $valorv = $caditens[0]['valorv'];
        $cst = $caditens[0]['cst'];
        $estoque = $caditens[0]['estoque'];

        titensFORMatualizar($id, $codbarras, $descricao, $unidade, $valorv, $cst, $estoque);

    }
    listartitens1($pdo);
}


// ACAO DE ATUALIZACAO UPDATE
//
if(!empty($atualizarID) && empty($deletarID) && $action=='Atualizar') {

    $codbarras = filter_input(INPUT_POST, 'codbarras', FILTER_DEFAULT);
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_DEFAULT);
    $unidade = filter_input(INPUT_POST, 'unidade', FILTER_DEFAULT);
    $valorv = filter_input(INPUT_POST, 'valorv', FILTER_DEFAULT);
    $cst = filter_input(INPUT_POST, 'cst', FILTER_DEFAULT);
    $estoque = filter_input(INPUT_POST, 'estoque', FILTER_DEFAULT);

    $comandoAtualizar = "UPDATE titens SET 
                         codbarras = '$codbarras',
                         descricao = '$descricao',
                         unidade = '$unidade',
                         valorv = '$valorv',
                         cst = '$cst',
                         estoque = '$estoque' 
                         WHERE id = $atualizarID;";

    $pdo->exec($comandoAtualizar);

    titensFORM();
    listartitens1($pdo);


}

require_once "rodape.php";