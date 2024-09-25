<?php
include("conexao.php");

$id = intval($_GET['id']); // Obtém o ID do fornecedor pela URL

// Busca as informações do fornecedor com base no ID
$sql_code = "SELECT * FROM fornecedores WHERE id = $id";
$sql_query = $mysqli->query($sql_code) or die($mysqli->error);
$fornecedor = $sql_query->fetch_assoc();

// Verifica se o formulário foi enviado para editar o fornecedor
if (isset($_POST['NomeFornecedor']) && isset($_POST['EmpresaFornecedor']) && isset($_POST['ContatoFornecedor'])) {
    $nome = $_POST['NomeFornecedor'];
    $empresa = $_POST['EmpresaFornecedor'];
    $contato = $_POST['ContatoFornecedor'];

    // Atualiza o fornecedor no banco de dados
    $sql_update = "UPDATE fornecedores SET nome = '$nome', empresa = '$empresa', contato = '$contato' WHERE id = $id";
    $mysqli->query($sql_update) or die($mysqli->error);

    header('Location: fornecedores.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Fornecedor</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> <!-- Inclui Tailwind CSS -->
</head>

<body class="bg-[#ebe7e0] text-gray-900">

    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg mt-6">
        <h1 class="text-2xl font-bold text-[#44749d] mb-4">Editar Fornecedor</h1>
        <a class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800 transition mb-4 inline-block" href="fornecedores.php">Voltar para a lista de Fornecedores</a>

        <form action="" method="post">
            <div class="mb-4">
                <label for="NomeFornecedor" class="block text-gray-700">Nome</label>
                <input value="<?php echo $fornecedor['nome']; ?>" name="NomeFornecedor" id="NomeFornecedor" type="text" required class="w-full p-2 border border-gray-300 rounded mt-2">
            </div>
            <div class="mb-4">
                <label for="EmpresaFornecedor" class="block text-gray-700">Empresa</label>
                <input value="<?php echo $fornecedor['empresa']; ?>" name="EmpresaFornecedor" id="EmpresaFornecedor" type="text" required class="w-full p-2 border border-gray-300 rounded mt-2">
            </div>
            <div class="mb-4">
                <label for="ContatoFornecedor" class="block text-gray-700">Contato</label>
                <input value="<?php echo $fornecedor['contato']; ?>" name="ContatoFornecedor" id="ContatoFornecedor" type="text" required class="w-full p-2 border border-gray-300 rounded mt-2">
            </div>
            <div class="mb-4">
                <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 transition">Salvar Alterações</button>
            </div>
        </form>
    </div>

</body>

</html>
