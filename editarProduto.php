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

</head>

<body>
    <div class="container">
        <h1>Editar Produto</h1>
        <form action="" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" value="<?= $produto['nome'] ?>" required>

            <label for="descricao">Descrição:</label>
            <input type="text" name="descricao" value="<?= $produto['descricao'] ?>" required>

            <label for="valor">Valor:</label>
            <input type="number" step="0.01" name="valor" value="<?= $produto['valor'] ?>" required>

            <label for="quantidade">Quantidade:</label>
            <input type="number" name="quantidade" value="<?= $produto['quantidade'] ?>" required>

            <label for="fornecedor">Fornecedor:</label>
            <select name="fornecedor_id">
                <?php while ($fornecedor = $fornecedores->fetch_assoc()): ?>
                    <option value="<?= $fornecedor['id'] ?>" <?= $fornecedor['id'] == $produto['fornecedor_id'] ? 'selected' : '' ?>>
                        <?= $fornecedor['nome'] ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
</body>

</html>
