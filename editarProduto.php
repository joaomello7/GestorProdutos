<?php
include('conexao.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql_code = "SELECT * FROM produtos WHERE id = $id";
    $produto = $mysqli->query($sql_code)->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $valor = $_POST['valor'];
        $quantidade = $_POST['quantidade'];
        $fornecedor_id = $_POST['fornecedor_id'];

        $total = $valor * $quantidade;

        $sql_code = "UPDATE produtos SET 
                     nome = '$nome', 
                     descricao = '$descricao',
                     valor = $valor,
                     quantidade = $quantidade,
                     total = $total,
                     fornecedor_id = $fornecedor_id
                     WHERE id = $id";

        $mysqli->query($sql_code) or die($mysqli->error);
        header("Location: produtos.php");
        exit;
    }

    // Selecionar fornecedores para o dropdown
    $sql_fornecedores = "SELECT id, nome FROM fornecedores";
    $fornecedores = $mysqli->query($sql_fornecedores);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> <!-- Inclui Tailwind CSS -->
</head>

<body class="bg-[#ebe7e0] text-gray-900">

    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg mt-6">
        <h1 class="text-2xl font-bold text-[#44749d] mb-4">Editar Produto</h1>

        <form action="" method="POST">
            <div class="mb-4">
                <label for="nome" class="block text-gray-700">Nome:</label>
                <input type="text" name="nome" value="<?= $produto['nome'] ?>" required class="w-full p-2 border border-gray-300 rounded mt-2">
            </div>

            <div class="mb-4">
                <label for="descricao" class="block text-gray-700">Descrição:</label>
                <input type="text" name="descricao" value="<?= $produto['descricao'] ?>" required class="w-full p-2 border border-gray-300 rounded mt-2">
            </div>

            <div class="mb-4">
                <label for="valor" class="block text-gray-700">Valor:</label>
                <input type="number" step="0.01" name="valor" value="<?= $produto['valor'] ?>" required class="w-full p-2 border border-gray-300 rounded mt-2">
            </div>

            <div class="mb-4">
                <label for="quantidade" class="block text-gray-700">Quantidade:</label>
                <input type="number" name="quantidade" value="<?= $produto['quantidade'] ?>" required class="w-full p-2 border border-gray-300 rounded mt-2">
            </div>

            <div class="mb-4">
                <label for="fornecedor" class="block text-gray-700">Fornecedor:</label>
                <select name="fornecedor_id" class="w-full p-2 border border-gray-300 rounded mt-2">
                    <?php while ($fornecedor = $fornecedores->fetch_assoc()): ?>
                        <option value="<?= $fornecedor['id'] ?>" <?= $fornecedor['id'] == $produto['fornecedor_id'] ? 'selected' : '' ?>>
                            <?= $fornecedor['nome'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="flex justify-between">
                <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 transition">Salvar Alterações</button>
                <a href="produtos.php" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800 transition">Voltar</a>
            </div>
        </form>
    </div>

</body>

</html>
