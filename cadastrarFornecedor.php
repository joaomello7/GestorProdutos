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
        echo "<p class='text-red-600'><b>ERRO: $erro</b></p>";
    } else {
        $sql_code = "INSERT INTO fornecedores (nome, empresa, contato, data_registro)
        VALUES ('$nome', '$empresa', '$contato', NOW())";
        $funcionou = $mysqli->query($sql_code) or die($mysqli->error);
        if ($funcionou) {
            $sucess = 'FORNECEDOR CADASTRADO COM SUCESSO';
            echo "<p class='text-green-600'><b>$sucess</b></p>";
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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> <!-- Inclui Tailwind CSS -->
</head>

<body class="bg-[#ebe7e0] text-gray-900">

    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg mt-6">
        <a class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800 transition mb-4 inline-block" href="fornecedores.php">Voltar</a>
        
        <h1 class="text-2xl font-bold text-[#44749d] mb-4">Cadastrar Fornecedor</h1>

        <form action="" method="post">
            <div class="mb-4">
                <label for="NomeFornecedor" class="block text-gray-700">Nome</label>
                <input value="<?php if (isset($_POST['NomeFornecedor'])) echo $_POST['NomeFornecedor']; ?>" name="NomeFornecedor" id="NomeFornecedor" type="text" required class="w-full p-2 border border-gray-300 rounded mt-2">
            </div>
            <div class="mb-4">
                <label for="EmpresaFornecedor" class="block text-gray-700">Empresa</label>
                <input value="<?php if (isset($_POST['EmpresaFornecedor'])) echo $_POST['EmpresaFornecedor']; ?>" name="EmpresaFornecedor" id="EmpresaFornecedor" type="text" required class="w-full p-2 border border-gray-300 rounded mt-2">
            </div>
            <div class="mb-4">
                <label for="ContatoFornecedor" class="block text-gray-700">Contato</label>
                <input value="<?php if (isset($_POST['ContatoFornecedor'])) echo $_POST['ContatoFornecedor']; ?>" placeholder="(44)99999-9999" name="ContatoFornecedor" id="ContatoFornecedor" type="text" required class="w-full p-2 border border-gray-300 rounded mt-2">
            </div>
            <div class="mb-4">
                <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 transition">Salvar</button>
            </div>
        </form>
    </div>

</body>

</html>
