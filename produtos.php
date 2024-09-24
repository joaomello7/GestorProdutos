<?php
include('conexao.php');

// Função para listar produtos
function listarProdutos($mysqli) {
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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="styles/produtos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

<body>
    <div class="container">
        <h1>Lista de Produtos</h1>
        <a href="cadastrarProduto.php" class="add-btn">Cadastrar Novo Produto</a>
        <a href="painel.php" class="add-btn">Voltar</a>

        <!-- Formulário para enviar os produtos selecionados -->
        <form id="cestaForm" action="cesta.php" method="POST">
            <table>
                <thead>
                    <tr>
                        <th>Selecionar</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Quantidade</th>
                        <th>Total</th>
                        <th>Fornecedor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($produto = $produtos->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="produtos[]" value="<?= $produto['id'] ?>">
                            </td>
                            <td><?= $produto['nome'] ?></td>
                            <td><?= $produto['descricao'] ?></td>
                            <td>R$ <?= number_format($produto['valor'], 2, ',', '.') ?></td>
                            <td><?= $produto['quantidade'] ?></td>
                            <td>R$ <?= number_format($produto['total'], 2, ',', '.') ?></td>
                            <td><?= $produto['nome_fornecedor'] ?></td>
                            <td>
                                <a href="editarProduto.php?id=<?= $produto['id'] ?>" class="edit-btn">Editar</a>
                                <a href="produtos.php?delete=<?= $produto['id'] ?>" onclick="return confirm('Deseja realmente deletar o produto?')" class="delete-btn">Deletar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <button type="submit" class="add-to-cart-btn">Adicionar à Cesta</button>
        </form>
    </div>
</body>

</html>
