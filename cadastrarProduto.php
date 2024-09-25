<?php
$erro = false;

// Função para limpar o campo de valor e quantidade
function limpar_texto($str) {
    return preg_replace("/[^0-9.]/", "", $str);
}

// Inclui o arquivo de conexão com o banco de dados
include("conexao.php");

// Função para buscar os fornecedores cadastrados no banco de dados
function listarFornecedores($mysqli) {
    $sql_fornecedores = "SELECT id, nome FROM fornecedores";
    $query_fornecedores = $mysqli->query($sql_fornecedores) or die($mysqli->error);

    $fornecedores = [];

    while ($fornecedor = $query_fornecedores->fetch_assoc()) {
        $fornecedores[] = $fornecedor;
    }

    return $fornecedores;
}

// Recupera a lista de fornecedores
$fornecedores = listarFornecedores($mysqli);

if (count($_POST) > 0) {
    // Campos do formulário
    $nome = $_POST['NomeProduto'];
    $descricao = $_POST['DescricaoProduto'];
    $valor = limpar_texto($_POST['ValorProduto']);
    $quantidade = limpar_texto($_POST['QuantidadeProduto']);
    $fornecedor_id = $_POST['FornecedorProduto'];

    // Validações de campos obrigatórios
    if (empty($nome)) {
        $erro = "Preencha o NOME do produto!";
    }
    if (empty($descricao)) {
        $erro = "Preencha a DESCRIÇÃO do produto!";
    }
    if (empty($valor)) {
        $erro = "Preencha o VALOR do produto!";
    }
    if (empty($quantidade)) {
        $erro = "Preencha a QUANTIDADE do produto!";
    }
    if (empty($fornecedor_id)) {
        $erro = "Selecione um FORNECEDOR!";
    }

    if ($erro) {
        echo "<p class='error'><b>ERRO: $erro</b></p>";
    } else {
        // Cálculo do total (valor * quantidade)
        $total = $valor * $quantidade;

        // Inserção no banco de dados
        $sql_code = "INSERT INTO produtos (nome, descricao, valor, quantidade, total, fornecedor_id, data_registro)
        VALUES ('$nome', '$descricao', '$valor', '$quantidade', '$total', '$fornecedor_id', NOW())";

        $funcionou = $mysqli->query($sql_code) or die($mysqli->error);

        if ($funcionou) {
            $sucess = 'PRODUTO CADASTRADO COM SUCESSO';
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
    <title>Cadastrar Produto</title>
</head>

<body>

    <div class="container">
        <form action="" method="post">
            <p>
                <label>Nome do Produto</label><br>
                <input value="<?php if (isset($_POST['NomeProduto'])) echo $_POST['NomeProduto']; ?>" name="NomeProduto" type="text">
            </p>
            <p>
                <label>Descrição do Produto</label><br>
                <input value="<?php if (isset($_POST['DescricaoProduto'])) echo $_POST['DescricaoProduto']; ?>" name="DescricaoProduto" type="text">
            </p>
            <p>
                <label>Valor</label><br>
                <input value="<?php if (isset($_POST['ValorProduto'])) echo $_POST['ValorProduto']; ?>" name="ValorProduto" type="text">
            </p>
            <p>
                <label>Quantidade</label><br>
                <input value="<?php if (isset($_POST['QuantidadeProduto'])) echo $_POST['QuantidadeProduto']; ?>" name="QuantidadeProduto" type="text">
            </p>
            <p>
                <label>Fornecedor</label><br>
                <select name="FornecedorProduto" required>
                    <option value="">Selecione um fornecedor</option>
                    <?php foreach ($fornecedores as $fornecedor): ?>
                        <option value="<?php echo $fornecedor['id']; ?>"><?php echo $fornecedor['nome']; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <button type="submit">Salvar</button>
                <a class="back-link" href="produtos.php">Voltar</a>
            </p>
        </form>
    </div>

</body>

</html>
