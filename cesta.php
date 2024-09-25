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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> <!-- Inclui Tailwind CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-100 text-gray-800">

    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg mt-6">
        <h1 class="text-3xl font-bold text-center text-[#44749d] mb-4">Cesta de Compras</h1>

        <!-- Exibe a cesta -->
        <h2 class="text-2xl font-semibold mb-2">Cesta Atual</h2>
        <div id="cesta-atual" class="border border-gray-300 p-4 rounded-lg">
            <?php if (!empty($_SESSION['cesta'])): ?>
                <ul class="list-disc list-inside">
                    <?php foreach ($_SESSION['cesta'] as $produto_id):
                        $sql_produto = "SELECT nome, valor FROM produtos WHERE id = $produto_id";
                        $produto = $mysqli->query($sql_produto)->fetch_assoc();
                        ?>
                        <li class="flex justify-between items-center mb-2">
                            <span><?= $produto['nome'] ?></span>
                            <span>R$ <?= number_format($produto['valor'], 2, ',', '.') ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-red-600">A cesta está vazia!</p>
            <?php endif; ?>
        </div>

        <div class="flex justify-between mt-4">
            <form action="painel.php" method="GET">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Voltar ao Painel</button>
            </form>
            <button id="limpar-cesta-btn" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Limpar Cesta</button>
        </div>
    </div>

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
