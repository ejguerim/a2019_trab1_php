<?php


//=============================================================================
function listarcadgeral1($pdoConexao) {
//=============================================================================

    $consulta = $pdoConexao->query('SELECT * FROM cadgeral');
    $cadgeralArray = $consulta->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <?php

    echo "<table width=100% border=1 cellpadding=5 cellspacing=0 id=alter>";
    echo '<tr>'
        . '<td width="10%"> Excluir </td>'
        . '<td width="10%"> Alterar </td>'
        . '<td width="10%"> Tipo Cad </td>'
        . '<td width="10%"> Codigo </td>'
        . '<td width="15%"> Inscricao </td>'
        . '<td width="15%"> IE </td>'
        . '<td width="30%"> Nome </td>'
        . '<br>'
        . '</tr>';

    foreach ($cadgeralArray as $xcadgeral) {

        echo '<tr>'
            . '<td width=10%> <a href="cadastrogeralCRUD.php?DeletarID='
            . $xcadgeral['id'] . '">[Excluir]</a> </td>'
            . '<td width=10%> <a href="cadastrogeralCRUD.php?AtualizarID='
            . $xcadgeral['id']. '">[Atualizar]</a> </td>'
            . '<td width=10%>'. $xcadgeral['tipocadastro'] .'</td>'
            . '<td width=10%>'. $xcadgeral['id'] . '</td>'
            . '<td width=15%>'. $xcadgeral['inscricao'] . '</td>'
            . '<td width=15%>'. $xcadgeral['iestado'] . '</td>'
            . '<td width=30%>'. $xcadgeral['nome'] . '</td>'
            . '<br>'
            . '</tr>' . PHP_EOL;

    }

    echo '</table>';
    echo '<br>';

}




//=============================================================================
function listarcabdocumento1($pdoConexao) {
//=============================================================================

    $consulta = $pdoConexao->query('SELECT * FROM cabdocumento');
    $cadgeralArray = $consulta->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <?php

    echo "<table width=100% border=1 cellpadding=0 cellspacing=0 id=alter>";
    echo '<tr>'
        . '<td width="5%"> Excluir </td>'
        . '<td width="5%"> Alterar </td>'
        . '<td width="5%"> Tipo Mov </td>'
        . '<td width="30%"> Participante </td>'
        . '<td width="5%"> Mod Doc </td>'
        . '<td width="5%"> Serie </td>'
        . '<td width="5%"> Numero </td>'
        . '<td width="20%"> Data Mov </td>'
        . '<td width="10%"> Vlr Total </td>'
        . '<td width="5%"> Movimento </td>'
        . '<br>'
        . '</tr>';

    foreach ($cadgeralArray as $xcadgeral) {

        $consultaidcad = $pdoConexao->query('SELECT * FROM cadgeral where id='.$xcadgeral['idcad'] );
        $idcadArray = $consultaidcad->fetchAll(PDO::FETCH_ASSOC);
        $wnome = $idcadArray[0]['nome'];

        echo '<tr>'
            . '<td width=5%> <a href="cabdocumentoCRUD.php?DeletarID='
            . $xcadgeral['lc'] . '">[Excluir]</a> </td>'
            . '<td width=5%> <a href="cabdocumentoCRUD.php?AtualizarID='
            . $xcadgeral['lc']. '">[Atualizar]</a> </td>'
            . '<td width=5%>'. $xcadgeral['tipomov'] .'</td>'
            . '<td width=30%>'. $xcadgeral['idcad'] . ' - '. $wnome . '</td>'
            . '<td width=5%>'. $xcadgeral['modelodoc'] . '</td>'
            . '<td width=5%>'. $xcadgeral['seriedoc'] . '</td>'
            . '<td width=5%>'. $xcadgeral['numerodoc'] . '</td>'
            . '<td width=20%>'. $xcadgeral['datamov'] . '</td>'
            . '<td width=10%>'. $xcadgeral['valort'] . '</td>'
            . '<td width=5%> <a href="movitensCRUD.php?lccab='
            . $xcadgeral['lc']. '">[Movimento]</a> </td>'
            . '</tr>' . PHP_EOL;

    }

    echo '</table>';
    echo '<br>';


}



//=============================================================================
function listartitens1($pdoConexao) {
//=============================================================================

    $consulta = $pdoConexao->query('SELECT * FROM titens');
    $caditensArray = $consulta->fetchAll(PDO::FETCH_ASSOC);

    echo "<table width=100% border=1 cellpadding=0 cellspacing=0 id=alter>";
    echo '<tr>'
        . '<td width="10%"> Excluir </td>'
        . '<td width="10%"> Alterar </td>'
        . '<td width="10%"> ID </td>'
        . '<td width="10%"> Cod. Barras </td>'
        . '<td width="15%"> Descrição </td>'
        . '<td width="15%"> Valor Venda </td>'
        . '<td width="15%"> CST </td>'
        . '<td width="15%"> Estoque </td>'
        . '<td width="5%"> Und </td>'
        . '<br>'
        . '</tr>';

    foreach ($caditensArray as $xcaditens) {
        ?>
        <?php

        echo '<tr>'
            . '<td width=10%> <a href="titensCRUD.php?DeletarID='
            . $xcaditens['id'] . '">[Excluir]</a> </td>'
            . '<td width=10%> <a href="titensCRUD.php?AtualizarID='
            . $xcaditens['id']. '">[Atualizar]</a> </td>'
            . '<td width=10%>'. $xcaditens['id'] .'</td>'
            . '<td width=10%>'. $xcaditens['codbarras'] . '</td>'
            . '<td width=15%>'. $xcaditens['descricao'] . '</td>'
            . '<td width=15%>'. $xcaditens['valorv'] . '</td>'
            . '<td width=15%>'. $xcaditens['cst'] . '</td>'
            . '<td width=15%>'. $xcaditens['estoque'] . '</td>'
            . '<td width=5%>'. $xcaditens['unidade'] . '</td>'
            . '</tr>' . PHP_EOL;

    }

    echo '</table>';
    echo '<br>';

}




//=============================================================================
function listarmovitens1($pdoConexao, $lc) {
//=============================================================================

    $wtotal = 0;
    
    $consulta = $pdoConexao->query('SELECT * FROM movitens where lccab='.$lc);
    $caditensArray = $consulta->fetchAll(PDO::FETCH_ASSOC);


    $consulta2 = $pdoConexao->query('SELECT * FROM cabdocumento where lc='.$lc);
    $cabdocArray = $consulta2->fetchAll(PDO::FETCH_ASSOC);

    $consultaidcad = $pdoConexao->query('SELECT * FROM cadgeral where id='.$cabdocArray[0]['idcad'] );
    $idcadArray = $consultaidcad->fetchAll(PDO::FETCH_ASSOC);
    $wnome = $idcadArray[0]['nome'];

    ?>
    <?php

    echo "<table width=100% border=1 cellpadding=0 cellspacing=0 id=alter>";
    echo '<tr>'
        . '<td width="100%" align="center"> Documento Selecionado </td>'
        . '</tr>';
    echo '</table>';
    
    echo "<table width=100% border=1 cellpadding=5 cellspacing=0 id=alter>";
    echo '<tr>'
        . '<td width="5%"> Lc </td>'
        . '<td width="5%"> Tipo Mov </td>'
        . '<td width="40%"> Participante </td>'
        . '<td width="5%"> Mod Doc </td>'
        . '<td width="5%"> Serie </td>'
        . '<td width="5%"> Numero </td>'
        . '<td width="25%"> Data Mov </td>'
        . '<td width="10%"> Vlr Total </td>'
        . '</tr>';

        echo '<tr>'
            . '<td width=5%>'. $cabdocArray[0]['lc'] .'</td>'
            . '<td width=5%>'. $cabdocArray[0]['tipomov'] .'</td>'
            . '<td width=40%>'. $cabdocArray[0]['idcad'] . ' - '. $wnome. '</td>'
            . '<td width=5%>'. $cabdocArray[0]['modelodoc'] . '</td>'
            . '<td width=5%>'. $cabdocArray[0]['seriedoc'] . '</td>'
            . '<td width=5%>'. $cabdocArray[0]['numerodoc'] . '</td>'
            . '<td width=25%>'. $cabdocArray[0]['datamov'] . '</td>'
            . '<td width=10%>'. $cabdocArray[0]['valort'] . '</td>'
            . '</tr>' . PHP_EOL;

    echo '</table>';

    
    echo "<table width=100% border=1 cellpadding=5 cellspacing=0 id=alter>";
    echo '<tr>'
        . '<td width="10%"> Excluir </td>'
        . '<td width="10%"> Alterar </td>'
        . '<td width="10%"> LC </td>'
        . '<td width="30%"> Cod. Item/Barras/Descrição </td>'
        . '<td width="5%"> Lote </td>'
        . '<td width="10%"> Qtd </td>'
        . '<td width="10%"> Valor Un </td>'
        . '<td width="10%"> Valor Total </td>'
        . '<td width="5%"> CFOp </td>'
        . '<br>'
        . '</tr>';

    foreach ($caditensArray as $xcaditens) {
        ?>
        <?php
    
        $consultaiditem = $pdoConexao->query('SELECT * FROM titens where id='.$xcaditens['iditem'] );
        $iditemArray = $consultaiditem->fetchAll(PDO::FETCH_ASSOC);
        $wdescricao = $iditemArray[0]['codbarras'].' - '. $iditemArray[0]['descricao'];

        echo '<tr>'
            . '<td width=10%> <a href="movitensCRUD.php?DeletarID='
            . $xcaditens['lc'].'&lccab='. $xcaditens['lccab']. '">[Excluir]</a> </td>'
            . '<td width=10%> <a href="movitensCRUD.php?AtualizarID='
            . $xcaditens['lc']. '">[Atualizar]</a> </td>'
            . '<td width=10%>'. $xcaditens['lc'] .'</td>'
            . '<td width=30%>'. $xcaditens['iditem'] . ' - '. $wdescricao.  '</td>'
            . '<td width=5%>'. $xcaditens['lote'] . '</td>'
            . '<td width=10%>'. $xcaditens['qtd'] . '</td>'
            . '<td width=10%>'. $xcaditens['valorun'] . '</td>'
            . '<td width=10%>'. $xcaditens['valort'] . '</td>'
            . '<td width=5%>'. $xcaditens['cfop'] . '</td>'
            . '</tr>' . PHP_EOL;
        $wtotal = $wtotal + $xcaditens['valort'];

    }
    echo '</table>';

    echo "<table width=100% border=1 cellpadding=5 cellspacing=0 id=alter>";
    echo '<tr>'
        . '<td width="85%"> Total Registrado </td>'
        . '<td width="10%">' .$wtotal . '</td>'
        . '<td width="5%"> . </td>'
        . '</tr>';
    echo '</table>';
    echo '<br>';

}
