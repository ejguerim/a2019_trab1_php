
<?php

require_once "menu.html";

//=============================================================================
function cadastrogeralFORM() {
//=============================================================================
    ?>
    <br>
    <form method="post" action="cadastrogeralCRUD.php">

        Tipo Cadastro:
        <select name="tipocadastro">
            <option value="C"> Cliente </option>
            <option value="F"> Fornecedor </option>
        </select>
        <br>

        Nome:<input type="text" name="nome"/><br>
        Inscricao(CPF/CNPJ/CAEPF):<input type="text" name="inscricao"/><br>
        Inscrição Estado:<input type="text" name="iestado"/><br>
        Endereço:<input type="text" name="endereco"/><br>
        Numero:<input type="number" name="numero"/><br>
        CEP:<input type="number" name="cep"/><br>
        Código Municipio(IBGE):<input type="number" name="codmunicipio"/><br>

        <input type="submit" name="action" value="Cadastrar"/>
        <input type="reset" value="Limpar">
        <a href="menu.html">Inicio</a>
        <br>
    </form>

    <?php
}

//
//=============================================================================
function cadastrogeralFORMatualizar($id, $nome, $tipocadastro, $inscricao, $iestado, $endereco, $numero, $cep, $codmunicipio) {
//=============================================================================
    ?>
    <br>
    <form method="post">
        ID: <?php echo $id; ?><br>
        <input type="hidden" value="<?php echo $id; ?>" name="id">

        <select name="tipocadastro">
            <option value="C" <?php echo ($tipocadastro=='C')?'selected':'';  ?> > Cliente </option>
            <option value="F" <?php echo ($tipocadastro=='F')?'selected':'';  ?> > Fornecedor </option>
        </select>
        <br>

        Nome:<input type="text" value="<?php echo $nome; ?>" name="nome"/><br>
        Inscricao(CPF/CNPJ/CAEPF):<input type="text" value="<?php echo $inscricao; ?>" name="inscricao"/><br>
        Inscrição Estado:<input type="text" value="<?php echo $iestado; ?>" name="iestado"/><br>
        Endereço:<input type="text" value="<?php echo $endereco; ?>" name="endereco"/><br>
        Numero:<input type="text" value="<?php echo $numero; ?>" name="numero"/><br>
        CEP:<input type="text" value="<?php echo $cep; ?>" name="cep"/><br>
        Código Municipio(IBGE):<input type="number" value="<?php echo $codmunicipio; ?>" name="codmunicipio"/><br>

        <input type="submit" name="action" value="Atualizar"/>
        <a href="cadastrogeralCRUD.php">Cancelar</a>
        <a href="menu.html">Inicio</a>
        <br>
    </form>

    <?php
}





//=============================================================================
function cabdocumentoFORM($pdoConexao) {
//=============================================================================

    $consultacadgeral = $pdoConexao->query('SELECT * FROM cadgeral');
    $cadgeralArray = $consultacadgeral->fetchAll(PDO::FETCH_ASSOC);
    
    ?>

    <form method="post" action="cabdocumentoCRUD.php">

        Tipo Cadastro:
        <select name="tipomov">
            <option value="E"> Entrada </option>
            <option value="S"> Saida </option>
        </select>
        <br>

        Modelo Documento:
        <select name="modelodoc">
            <option value="55"> NFe </option>
            <option value="01"> Modelo 1 </option>
            <option value="65"> NFCe </option>
        </select>
        <br>

        Numero Documento:<input type="number" name="numerodoc"/><br>
        Serie Documento:<input type="text" name="seriedoc"/><br>
               
        Cadastro Fornecedor/Cliente:
        <select name="idcad">
            <?php
                foreach ($cadgeralArray as $xtemp) {
                    echo '<option value="' . $xtemp['id'] . '">'
                    . $xtemp['nome'] . '</option>' . PHP_EOL;
                }
            ?>
        </select>        
                
        Data Movimento<input type="date" name="datamov"/><br>
        Valor Total Documento:<input type="text" name="valort"/><br>

        <input type="submit" name="action" value="Cadastrar"/>
        <input type="reset" value="Limpar">
        <a href="menu.html">Inicio</a>
        <br>
    </form>

    <?php
}



//
//=============================================================================
function cabdocumentoFORMatualizar($pdoConexao, $lc, $tipomov, $modelodoc, $numerodoc, $seriedoc, $valort, $idcad, $datamov) {

//=============================================================================
    $new_date = date('Y-m-d', strtotime($datamov));

    $consultacadgeral = $pdoConexao->query('SELECT * FROM cadgeral');
    $cadgeralArray = $consultacadgeral->fetchAll(PDO::FETCH_ASSOC);

    ?>

    DATA: <?php echo $new_date; ?><br>

    <form method="post">
        LC: <?php echo $lc; ?><br>
        <input type="hidden" value="<?php echo $lc; ?>" name="lc">

        <select name="tipomov">
            <option value="E" <?php echo ($tipomov=='E')?'selected':'';  ?> > Entrada </option>
            <option value="S" <?php echo ($tipomov=='S')?'selected':'';  ?> > Saida </option>
        </select>
        <br>

        Modelo Documento:
        <select name="modelodoc">
            <option value="55" <?php echo ($modelodoc=='55')?'selected':''; ?> > NFe </option>
            <option value="01" <?php echo ($modelodoc=='01')?'selected':''; ?> > Modelo 1 </option>
            <option value="65" <?php echo ($modelodoc=='65')?'selected':''; ?> > NFCe </option>
        </select>
        <br>

        Numero Documento:<input type="number" value="<?php echo $numerodoc; ?>" name="numerodoc"/><br>
        Serie Documento:<input type="text" value="<?php echo $seriedoc; ?>" name="seriedoc"/><br>

        Cadastro Fornecedor/Cliente:
        <select name="idcad">
            <?php
                foreach ($cadgeralArray as $xtemp) { ?>
            <option value="<?= $xtemp['id'] ?>" <?= $xtemp['id'] == $idcad ? "selected" : "" ?>><?= $xtemp['nome'] ?></option>
            <?php
                }
            ?>
        </select>        

        Data Movimento<input type="date" value="<?php echo $new_date; ?>" name="datamov"/><br>
        Valor Total Documento:<input type="text" value="<?php echo $valort; ?>" name="valort"/><br>

        <input type="submit" name="action" value="Atualizar"/>
        <a href="cabdocumentoCRUD.php">Cancelar</a>
        <a href="menu.html">Inicio</a>
        <br>
    </form>

    <?php
}




//=============================================================================
function titensFORM() {
//=============================================================================
    ?>
    <form method="post" action="titensCRUD.php">

        Código de Barras :<input type="text" name="codbarras"/><br>
        Descrição:<input type="text" name="descricao"/><br>
        Unidade:<input type="text" name="unidade"/><br>
        Valor de Venda :<input type="text" name="valorv"/><br>
        CST:<input type="text" name="cst"/><br>
        Estoque:<input type="text" name="estoque"/><br>

        <input type="submit" name="action" value="Cadastrar"/>
        <input type="reset" value="Limpar">
        <a href="menu.html"><input type="button" value="Inicio" > </a> 
        <br>
    </form>

    <?php
}

//
//=============================================================================
function titensFORMatualizar($id, $codbarras, $descricao, $unidade, $valorv, $cst, $estoque) {
//=============================================================================
    ?>
    <form method="post">

        ID: <?php echo $id; ?><br>
        <input type="hidden" value="<?php echo $id; ?>" name="id">

        Código de Barras :<input type="text" value="<?php echo $codbarras; ?>" name="codbarras"/><br>
        Descrição:<input type="text" value="<?php echo $descricao; ?>" name="descricao"/><br>
        Unidade:<input type="text" value="<?php echo $unidade; ?>" name="unidade"/><br>
        Valor de Venda :<input type="text" value="<?php echo $valorv; ?>" name="valorv"/><br>
        CST:<input type="text" value="<?php echo $cst; ?>" name="cst"/><br>
        Estoque:<input type="text" value="<?php echo $estoque; ?>" name="estoque"/><br>

        <input type="submit" name="action" value="Atualizar"/>
        <a href="titensCRUD.php">Cancelar</a>
        <a href="menu.html">Inicio</a>
        <br>
    </form>
    <?php

}



//=============================================================================
function movitensFORM($pdoConexao, $lccab) {
//=============================================================================

    $consultatitens = $pdoConexao->query('SELECT * FROM titens');
    $titensArray = $consultatitens->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <form method="post" action="movitensCRUD.php">

        Lc Documento: <?php echo $lccab; ?><br>
        <input type="hidden" value="<?php echo $lccab; ?>" name="lccab">

        Código do Item:
        <select name="iditem">
            <?php
                foreach ($titensArray as $xtitens) {
                    echo '<option value="' . $xtitens['id'] . '">'
                    . $xtitens['descricao'] . '</option>' . PHP_EOL;
                }
            ?>
        </select>        

        Lote:<input type="text" name="lote"/><br>

        Qtd:<input type="text" name="qtd"/><br>
        Valor Unitário:<input type="text" name="valorun"/><br>
        Valor Total:<input type="text" name="valort"/><br>

        CFOp:<input type="text" name="cfop"/><br>

        <input type="submit" name="action" value="Cadastrar"/>
        <input type="reset" value="Limpar">
        <a href="menu.html"><input type="button" value="Inicio" > </a>
        <br>

    </form>

    <?php
}

//
//=============================================================================
function movitensFORMatualizar($pdoConexao, $lc, $lote, $cfop, $qtd, $valorun, $valort, $iditem, $lccab) {
//=============================================================================
    
    $consultatitens = $pdoConexao->query('SELECT * FROM titens');
    $titensArray = $consultatitens->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <form method="post">

        Lc: <?php echo $lc; ?><br>
        <input type="hidden" value="<?php echo $lc; ?>" name="lc">
        <input type="hidden" value="<?php echo $lccab; ?>" name="lccab">

        Código de Item:
        <select name="iditem">
            <?php
                foreach ($titensArray as $xtitens) { ?>
            <option value="<?= $xtitens['id'] ?>" <?= $xtitens['id'] == $iditem ? "selected" : "" ?>><?= $xtitens['descricao'] ?></option>
            <?php
                }
            ?>
        </select>        

        Lote:<input type="text" value="<?php echo $lote; ?>" name="lote"/><br>
        Qtd:<input type="text" value="<?php echo $qtd; ?>" name="qtd"/><br>
        Valor Unitário:<input type="text" value="<?php echo $valorun; ?>" name="valorun"/><br>
        Valor Total:<input type="text" value="<?php echo $valort; ?>" name="valort"/><br>
        CFOp:<input type="text" value="<?php echo $cfop; ?>" name="cfop"/><br>

        <input type="submit" name="action" value="Atualizar"/>
        <a href="movitensCRUD.php?lccab=<?php echo $lccab ?>">Cancelar</a>
        <a href="menu.html">Inicio</a>
        <br>
    </form>
    <?php

}



