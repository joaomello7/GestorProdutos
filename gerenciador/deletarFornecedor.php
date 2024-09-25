<?php
include("conexao.php");

// Verifica se o ID foi passado via POST para exclusão via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Verifica se o fornecedor existe
    $sql_code = "SELECT * FROM fornecedores WHERE id = $id";
    $sql_query = $mysqli->query($sql_code) or die(json_encode(['success' => false, 'message' => 'Erro na consulta ao fornecedor: ' . $mysqli->error]));

    if ($sql_query->num_rows == 0) {
        // Retorna uma resposta em JSON informando que o fornecedor não foi encontrado
        echo json_encode(['success' => false, 'message' => 'Fornecedor não encontrado.']);
        exit;
    }

    // Deleta os produtos associados ao fornecedor
    $sql_code = "DELETE FROM produtos WHERE fornecedor_id = $id";
    $mysqli->query($sql_code) or die(json_encode(['success' => false, 'message' => 'Erro ao deletar produtos: ' . $mysqli->error]));

    // Deleta o fornecedor
    $sql_code = "DELETE FROM fornecedores WHERE id = $id";
    $funcionou = $mysqli->query($sql_code);

    if ($funcionou) {
        // Retorna uma resposta em JSON informando que a exclusão foi bem-sucedida
        echo json_encode(['success' => true, 'message' => 'Fornecedor e produtos associados excluídos com sucesso!']);
    } else {
        // Retorna uma resposta em JSON informando que ocorreu um erro ao excluir
        echo json_encode(['success' => false, 'message' => 'Erro ao tentar excluir o fornecedor: ' . $mysqli->error]);
    }

    exit;
}

// Caso a página seja acessada diretamente, carrega os dados do fornecedor
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
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Fornecedor</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <div class="container">
        <h1>Deletar Fornecedor</h1>
        <a class="back-link" href="fornecedores.php">Voltar</a>

        <p>Tem certeza que deseja excluir o fornecedor <strong><?php echo $fornecedor['nome']; ?></strong>?</p>
        
        <!-- Formulário para exclusão via AJAX -->
        <form id="deleteForm" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit">Confirmar Exclusão</button>
        </form>

        <p id="responseMessage"></p> <!-- Elemento para exibir a mensagem de resposta -->
    </div>

    <script>
        $(document).ready(function() {
            // Manipula a submissão do formulário via AJAX
            $('#deleteForm').on('submit', function(e) {
                e.preventDefault(); // Impede o comportamento padrão do formulário

                $.ajax({
                    url: 'deletarFornecedor.php', // Requisição enviada para o próprio arquivo
                    type: 'POST',
                    data: $(this).serialize(), // Envia os dados do formulário
                    dataType: 'json', // Espera uma resposta em JSON
                    success: function(response) {
                        $('#responseMessage').text(response.message); // Exibe a mensagem de resposta
                        if (response.success) {
                            // Redireciona após a exclusão com sucesso
                            setTimeout(function() {
                                window.location.href = 'fornecedores.php'; // Redireciona para a lista de fornecedores
                            }, 2000);
                        }
                    },
                    error: function() {
                        $('#responseMessage').text('Erro ao tentar excluir o fornecedor.'); // Mensagem de erro caso a requisição falhe
                    }
                });
            });
        });
    </script>

</body>
</html>
