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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Inclui jQuery -->
</head>
<body>

    <div class="container">
        <h1>Fornecedores</h1>
        <a class="back-link" href="painel.php">Voltar ao Painel</a>
        <a class="back-link" href="cadastrarFornecedor.php">Cadastrar Fornecedor</a>

        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Empresa</th>
                    <th>Contato</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="fornecedores-tbody"> <!-- ID para acessar via jQuery -->
                <?php while ($fornecedor = $sql_query->fetch_assoc()): ?>
                    <tr id="fornecedor-<?php echo $fornecedor['id']; ?>"> <!-- Adiciona um ID único para cada linha -->
                        <td><?php echo $fornecedor['nome']; ?></td>
                        <td><?php echo $fornecedor['empresa']; ?></td>
                        <td><?php echo $fornecedor['contato']; ?></td>
                        <td>
                            <!-- Link para editar o fornecedor -->
                            <a href="editarFornecedor.php?id=<?php echo $fornecedor['id']; ?>">Editar</a> | 
                            <!-- Botão para deletar via AJAX -->
                            <button class="delete-btn" data-id="<?php echo $fornecedor['id']; ?>">Deletar</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            // Manipulador de clique para o botão de exclusão
            $('.delete-btn').click(function() {
                const id = $(this).data('id'); // Obtém o ID do fornecedor

                if (confirm('Tem certeza que deseja excluir este fornecedor?')) {
                    $.ajax({
                        url: 'deletarFornecedor.php',
                        type: 'POST',
                        data: { id: id },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // Remove a linha da tabela
                                $('#fornecedor-' + id).remove();
                                alert(response.message);
                            } else {
                                alert(response.message); // Exibe mensagem de erro se houver
                            }
                        },
                        error: function() {
                            alert('Erro ao tentar excluir o fornecedor.');
                        }
                    });
                }
            });
        });
    </script>

</body>
</html>
