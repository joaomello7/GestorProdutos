<?php
include('conexao.php');

// Função para listar produtos
function listarProdutos($mysqli)
{
    $sql_code = "SELECT p.*, f.nome AS nome_fornecedor FROM produtos p
                 LEFT JOIN fornecedores f ON p.fornecedor_id = f.id";
    $sql_query = $mysqli->query($sql_code) or die($mysqli->error);
    return $sql_query;
}

// Função para deletar produto
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql_code = "DELETE FROM produtos WHERE id = $id";
    $mysqli->query($sql_code) or die($mysqli->error);
    header("Location: produtos.php");
    exit;
}

$produtos = listarProdutos($mysqli);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        // Função para verificar se pelo menos uma checkbox está marcada
        function validarSelecao() {
            const checkboxes = document.querySelectorAll('input[name="produtos[]"]:checked');
            if (checkboxes.length === 0) {
                alert("Por favor, selecione pelo menos um produto para adicionar à cesta.");
                return false;
            }
            return true;
        }

        $(document).ready(function () {
            // Função para adicionar produtos à cesta via AJAX
            $('#cestaForm').on('submit', function (e) {
                e.preventDefault();  // Previne o envio normal do formulário

                if (!validarSelecao()) {
                    return;  // Interrompe o processo se não houver seleção
                }

                $.ajax({
                    url: 'cesta.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            alert(response.message);
                            // Redireciona para o painel após o sucesso
                            window.location.href = "painel.php";
                        } else {
                            alert("Ocorreu um erro ao adicionar os produtos.");
                        }
                    },
                    error: function () {
                        alert("Erro ao processar a solicitação. Tente novamente.");
                    }
                });
            });
        });
    </script>
</head>

<body class="bg-[#ebe7e0] text-gray-900">
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg mt-6">
        <h1 class="text-2xl font-bold text-[#44749d]">Lista de Produtos</h1>
        <div class="mt-4">
            <a href="cadastrarProduto.php"
                class="bg-blue-700 text-white px-8 py-2 rounded hover:bg-blue-800 transition">Cadastrar Novo Produto</a>
            <a href="painel.php"
                class="ml-4 bg-blue-700 text-white px-8 py-2 rounded hover:bg-blue-800 transition">Voltar</a>
        </div>

        <form id="cestaForm" action="cesta.php" method="POST" class="mt-6">
            <table class="min-w-full bg-white">
                <thead class="bg-[#44749d] text-white">
                    <tr>
                        <th class="py-2 px-4">Selecionar</th>
                        <th class="py-2 px-4">Nome</th>
                        <th class="py-2 px-4">Descrição</th>
                        <th class="py-2 px-4">Valor</th>
                        <th class="py-2 px-4">Quantidade</th>
                        <th class="py-2 px-4">Total</th>
                        <th class="py-2 px-4">Fornecedor</th>
                        <th class="py-2 px-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($produto = $produtos->fetch_assoc()): ?>
                        <tr class="border-b">
                            <td class="py-2 px-4">
                                <input type="checkbox" name="produtos[]" value="<?= $produto['id'] ?>">
                            </td>
                            <td class="py-2 px-4"><?= $produto['nome'] ?></td>
                            <td class="py-2 px-4"><?= $produto['descricao'] ?></td>
                            <td class="py-2 px-4">R$ <?= number_format($produto['valor'], 2, ',', '.') ?></td>
                            <td class="py-2 px-4"><?= $produto['quantidade'] ?></td>
                            <td class="py-2 px-4">R$ <?= number_format($produto['total'], 2, ',', '.') ?></td>
                            <td class="py-2 px-4"><?= $produto['nome_fornecedor'] ?></td>
                            <td class="py-2 px-4">
                                <a href="editarProduto.php?id=<?= $produto['id'] ?>"
                                    class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 transition">Editar</a>
                                <a href="produtos.php?delete=<?= $produto['id'] ?>"
                                    onclick="return confirm('Deseja realmente deletar o produto?')"
                                    class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 transition">Deletar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <br>
            <button type="submit"
                class="bg-green-700 text-white px-4 py-2 rounded hover:bg-blue-800 transition">Adicionar à
                Cesta</button>


        </form>
    </div>
</body>

</html>