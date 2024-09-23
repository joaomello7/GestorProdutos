<?php
include("conexao.php");

// Verifica se o ID foi passado via GET
if (!isset($_GET['id'])) {
    die("Fornecedor não encontrado.");
}

$id = intval($_GET['id']);
$sql_code = "SELECT * FROM fornecedores WHERE id = $id";
$sql_query = $mysqli->query($sql_code) or die($mysqli->error);

if ($sql_query->num_rows == 0) {
    die("Fornecedor não encontrado.");
}

$fornecedor = $sql_query->fetch_assoc();

// Verifica se o formulário de confirmação foi enviado
if (isset($_POST['confirmar'])) {
    $sql_code = "DELETE FROM fornecedores WHERE id = $id";
    $funcionou = $mysqli->query($sql_code) or die($mysqli->error);

    if ($funcionou) {
        echo "<p><b>Fornecedor excluído com sucesso!</b></p>";
        header("Location: fornecedores.php");
        exit();
    } else {
        echo "<p><b>Erro ao tentar excluir o fornecedor.</b></p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Fornecedor</title>
    <link rel="stylesheet" href="styles/darkmode.css"> <!-- Link para o CSS externo -->
</head>
<body>

    <div class="container">
        <h1>Deletar Fornecedor</h1>
        <a class="back-link" href="fornecedores.php">Voltar</a>

        <p>Tem certeza que deseja excluir o fornecedor <strong><?php echo $fornecedor['nome']; ?></strong>?</p>
        
        <form action="" method="post">
            <button type="submit" name="confirmar">Confirmar Exclusão</button>
        </form>
    </div>

</body>
</html>
