<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: index.php"); // Redireciona para a página de login se não estiver logado
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle</title>
    <link rel="stylesheet" href="styles/home.css"> <!-- Link para o arquivo CSS externo -->
</head>

<body>

    <!-- Navbar -->
    <nav>
        <ul>
            <li><a href="produtos.php">Produtos</a></li>
            <li><a href="fornecedores.php">Fornecedores</a></li>
            <li><a href="cesta.php">Criar Cesta</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Conteúdo Principal -->
    <div class="container">
        <h1>Bem-vindo, <?php echo $_SESSION['nome']; ?>!</h1>
        <p>Escolha uma opção na barra de navegação acima para começar.</p>
    </div>

</body>

</html>
