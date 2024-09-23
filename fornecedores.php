<?php
include("conexao.php");

// Busca todos os fornecedores do banco de dados
$sql_code = "SELECT * FROM fornecedores";
$sql_query = $mysqli->query($sql_code) or die($mysqli->error);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornecedores</title>
    <link rel="stylesheet" href="styles/fornecedores.css"> <!-- Vinculando o CSS externo -->
</head>
<body>

    <div class="container">
        <h1>Fornecedores</h1>
        <a class="back-link" href="painel.php">Voltar ao Painel</a>

        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Empresa</th>
                    <th>Contato</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fornecedor = $sql_query->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $fornecedor['nome']; ?></td>
                        <td><?php echo $fornecedor['empresa']; ?></td>
                        <td><?php echo $fornecedor['contato']; ?></td>
                        <td>
                            <!-- Link para editar o fornecedor -->
                            <a href="editarFornecedor.php?id=<?php echo $fornecedor['id']; ?>">Editar</a> | 
                            <!-- Link para deletar o fornecedor -->
                            <a href="deletarFornecedor.php?id=<?php echo $fornecedor['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este fornecedor?')">Deletar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
