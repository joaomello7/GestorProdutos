<?php
include("conexao.php");

$erro = ''; // Variável para armazenar mensagens de erro ou sucesso

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST["nome"])) {
        $erro = 'Preencha Seu Nome De Usuário!';
    } else if (empty($_POST["senha"])) {
        $erro = 'Preencha Sua Senha!';
    } else {
        // Escapa os dados de entrada para prevenir SQL Injection
        $nome = $mysqli->real_escape_string($_POST['nome']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        // Verifica se o usuário já existe
        $sql_check = "SELECT * FROM login WHERE nome_login = '$nome'";
        $result = $mysqli->query($sql_check);

        if ($result->num_rows > 0) {
            $erro = "Nome de Usuário já cadastrado!";
        } else {
            // Criptografa a senha antes de armazenar
            $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

            // SQL para inserir o novo usuário no banco de dados
            $sql_insert = "INSERT INTO login (nome_login, senha_login, senha_criptografada) 
                           VALUES ('$nome', '$senha', '$senha_criptografada')";

            if ($mysqli->query($sql_insert)) {
                $erro = "Usuário cadastrado com sucesso!";
                // Limpa os campos após o cadastro bem-sucedido
                $_POST['nome'] = '';
                $_POST['senha'] = '';
            } else {
                $erro = "Erro ao cadastrar usuário: " . $mysqli->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-[#c6d4e1] flex items-center justify-center min-h-screen">

    <form action="" method="POST" class="bg-white rounded-lg shadow-lg p-6 w-80">
        <h2 class="text-center text-lg font-semibold text-[#44749d]">Cadastro</h2>

        <!-- Exibe a mensagem de erro ou sucesso -->
        <?php if ($erro): ?>
            <div class="text-red-600 text-sm text-center mb-4">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <div class="mb-4">
            <label for="nome" class="block text-sm text-[#44749d]">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo isset($_POST['nome']) ? $_POST['nome'] : ''; ?>" required class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-[#44749d]">
        </div>
        <div class="mb-4">
            <label for="senha" class="block text-sm text-[#44749d]">Senha:</label>
            <input type="password" id="senha" name="senha" required class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-[#44749d]">
        </div>
        <div class="mb-4">
        <button type="submit" style="background-color: #44749d; color: white;" class="w-full p-2 rounded-md hover:bg-[#365f7e] transition duration-200">Cadastrar</button>
        </div>

        <div class="text-center">
            <a href="login.php" class="text-[#44749d] hover:underline">Já possui uma conta? Faça login!</a>
        </div>
    </form>

</body>

</html>
