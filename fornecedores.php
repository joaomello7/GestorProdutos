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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> <!-- Inclui Tailwind CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Inclui jQuery -->
</head>
<body class="bg-[#ebe7e0] text-gray-900">

    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg mt-6">
        <h1 class="text-2xl font-bold text-[#44749d]">Fornecedores</h1>

        <div class="mt-4">
            <a href="painel.php"
               class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 transition">Voltar ao Painel</a>
            <a href="cadastrarFornecedor.php"   
               class="ml-4 bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 transition">Cadastrar Fornecedor</a>
        </div>

        <table class="min-w-full mt-6 bg-white border border-gray-300">
            <thead class="bg-[#44749d] text-black">
                <tr>
                    <th class="py-2 px-4 text-left">Nome</th>
                    <th class="py-2 px-4 text-left">Empresa</th>
                    <th class="py-2 px-4 text-left">Contato</th>
                    <th class="py-2 px-4 text-left">Ações</th>
                </tr>
            </thead>
            <tbody id="fornecedores-tbody"> <!-- ID para acessar via jQuery -->
                <?php while ($fornecedor = $sql_query->fetch_assoc()): ?>
                    <tr id="fornecedor-<?php echo $fornecedor['id']; ?>" class="border-b">
                        <td class="py-2 px-4"><?php echo $fornecedor['nome']; ?></td>
                        <td class="py-2 px-4"><?php echo $fornecedor['empresa']; ?></td>
                        <td class="py-2 px-4"><?php echo $fornecedor['contato']; ?></td>
                        <td class="py-2 px-4">
                            <a href="editarFornecedor.php?id=<?php echo $fornecedor['id']; ?>"
                               class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 transition">Editar</a>
                            <button class="delete-btn bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 ml-2 transition" data-id="<?php echo $fornecedor['id']; ?>">Deletar</button>
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
