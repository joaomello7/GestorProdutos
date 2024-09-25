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
</head>

<body>

    <div class="container">
        <h1>Editar Fornecedor</h1>
        <a class="back-link" href="fornecedores.php">Voltar para a lista de Fornecedores</a>

        <form action="" method="post">
            <div class="form-group">
                <label for="NomeFornecedor">Nome</label>
                <input value="<?php echo $fornecedor['nome']; ?>" name="NomeFornecedor" id="NomeFornecedor" type="text" required>
            </div>
            <div class="form-group">
                <label for="EmpresaFornecedor">Empresa</label>
                <input value="<?php echo $fornecedor['empresa']; ?>" name="EmpresaFornecedor" id="EmpresaFornecedor" type="text" required>
            </div>
            <div class="form-group">
                <label for="ContatoFornecedor">Contato</label>
                <input value="<?php echo $fornecedor['contato']; ?>" name="ContatoFornecedor" id="ContatoFornecedor" type="text" required>
            </div>
            <div class="form-group">
                <button type="submit">Salvar Alterações</button>
            </div>
        </form>
    </div>

</body>

</html>
