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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-[#ebe7e0] flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-[#44749d] shadow-md">
    <ul class="flex space-x-6 p-4">
        <li><a href="produtos.php" class="text-gray-900 hover:bg-[#365f7e] px-3 py-2 rounded transition">Produtos</a></li>
        <li><a href="fornecedores.php" class="text-gray-900 hover:bg-[#365f7e] px-3 py-2 rounded transition">Fornecedores</a></li>
        <li><a href="cesta.php" class="text-gray-900 hover:bg-[#365f7e] px-3 py-2 rounded transition">Cesta</a></li>
        <li><a href="logout.php" class="text-gray-900 hover:bg-[#365f7e] px-3 py-2 rounded transition">Logout</a></li>
    </ul>
</nav>


    <!-- Conteúdo Principal -->
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg mt-6 flex-1">
        <h1 class="text-black text-2xl font-bold">Bem-vindo, <?php echo $_SESSION['nome']; ?>!</h1>
        <p class="mt-2 text-black">Escolha uma opção na barra de navegação acima para começar.</p>
    </div>


</body>

</html>