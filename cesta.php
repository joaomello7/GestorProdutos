<?php
include('conexao.php');

// Iniciar a sessão
if (!isset($_SESSION)) {
    session_start();
}

// Inicializa a cesta
if (!isset($_SESSION['cesta'])) {
    $_SESSION['cesta'] = [];
}

// Adiciona os produtos ao carrinho somente se o botão foi pressionado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produtos'])) {
    $produtos_selecionados = $_POST['produtos'];
    
    foreach ($produtos_selecionados as $produto_id) {
        if (!in_array($produto_id, $_SESSION['cesta'])) {
            $_SESSION['cesta'][] = $produto_id; // Adiciona o produto à sessão
        }
    }

    echo json_encode(['success' => true, 'message' => 'Produtos adicionados à cesta!']);
    exit;
}

// Limpar a cesta
if (isset($_POST['acao']) && $_POST['acao'] === 'limpar_cesta') {
    $_SESSION['cesta'] = [];
    echo json_encode(['success' => true, 'message' => 'Cesta limpa com sucesso!']);
    exit;
}

// Buscar todos os produtos da cesta
$sql_produtos = "SELECT id, nome, valor FROM produtos";
$produtos = $mysqli->query($sql_produtos);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cesta de Compras</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>Cesta de Compras</h1>

    <!-- Exibe a cesta -->
    <h2>Cesta Atual</h2>
    <div id="cesta-atual">
        <?php if (!empty($_SESSION['cesta'])): ?>
            <ul>
                <?php foreach ($_SESSION['cesta'] as $produto_id):
                    $sql_produto = "SELECT nome, valor FROM produtos WHERE id = $produto_id";
                    $produto = $mysqli->query($sql_produto)->fetch_assoc();
                    ?>
                    <li><?= $produto['nome'] ?> - R$ <?= number_format($produto['valor'], 2, ',', '.') ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>A cesta está vazia!</p>
        <?php endif; ?>
    </div>

    <form action="painel.php" method="GET">
        <button type="submit" class="painel-btn">Voltar ao Painel</button>
    </form>
    <button id="limpar-cesta-btn">Limpar Cesta</button>

    <script>
        $(document).ready(function () {
            // Função para limpar a cesta
            $('#limpar-cesta-btn').on('click', function () {
                $.ajax({
                    url: 'cesta.php',
                    type: 'POST',
                    data: { acao: 'limpar_cesta' },
                    dataType: 'json',
                    success: function (response) {
                        alert(response.message);
                        $('#cesta-atual').load('cesta.php #cesta-atual > *'); // Recarrega a cesta
                    }
                });
            });
        });
    </script>
</body>

</html>
