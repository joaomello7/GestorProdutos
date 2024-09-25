<?php
$erro = false;
// Função para limpar o campo de contato
function limpar_texto($str) {
    return preg_replace("/[^0-9]/", "", $str);
}

if (count($_POST) > 0) {
    include("conexao.php");
    $nome = $_POST['NomeFornecedor'];
    $empresa = $_POST['EmpresaFornecedor'];
    $contato = $_POST['ContatoFornecedor'];

    if (empty($nome)) {
        $erro = "Preencha o NOME!";
    }
    if (empty($empresa)) {
        $erro = "Campo EMPRESA vazio!";
    }
    if (empty($contato)) {
        $erro = "Preencha o CONTATO!";
    }
    if (!empty($contato)) {
        $contato = limpar_texto($contato);
        if (strlen($contato) != 11) {
            $erro = "O TELEFONE DEVE SER PREENCHIDO NO PADRÃO CORRETO";
        }
    }

    if ($erro) {
        echo "<p class='error'><b>ERRO: $erro</b></p>";
    } else {
        $sql_code = "INSERT INTO fornecedores (nome, empresa, contato, data_registro)
        VALUES ('$nome', '$empresa', '$contato', NOW())";
        $funcionou = $mysqli->query($sql_code) or die($mysqli->error);
        if ($funcionou) {
            $sucess = 'FORNECEDOR CADASTRADO COM SUCESSO';
            echo "<p class='success'><b>$sucess</b></p>";
            unset($_POST);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Fornecedor</title>
</head>

<body>

    <div class="container">
        <a class="back-link" href="fornecedores.php">Voltar</a>
        <form action="" method="post">
            <p>
                <label>Nome</label><br>
                <input value="<?php if (isset($_POST['NomeFornecedor'])) echo $_POST['NomeFornecedor']; ?>" name="NomeFornecedor" type="text">
            </p>
            <p>
                <label>Empresa</label><br>
                <input value="<?php if (isset($_POST['EmpresaFornecedor'])) echo $_POST['EmpresaFornecedor']; ?>" name="EmpresaFornecedor" type="text">
            </p>
            <p>
                <label>Contato</label><br>
                <input value="<?php if (isset($_POST['ContatoFornecedor'])) echo $_POST['ContatoFornecedor']; ?>" placeholder="(44)99999-9999" name="ContatoFornecedor" type="text">
            </p>
            <p>
                <button type="submit">Salvar</button>
            </p>
        </form>
    </div>

</body>

</html>
