<?php
include("conexao.php");

$erro = ''; // Inicializa uma variável para armazenar a mensagem de erro

if (isset($_POST["nome"]) || isset($_POST["senha"])) {
    if (strlen($_POST["nome"]) == 0) {
        $erro = 'Preencha Seu Nome De Usuario!';
    } else if (strlen($_POST["senha"]) == 0) {
        $erro = 'Preencha Sua Senha!';
    } else {
        // Escapa os dados de entrada para prevenir SQL Injection
        $nome = $mysqli->real_escape_string($_POST['nome']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        // SQL para selecionar o usuário pelo nome de login
        $sql_code = "SELECT * FROM login WHERE nome_login = '$nome'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na Execução do Código SQL: " . $mysqli->error);

        // Verifica se o usuário existe
        if ($sql_query->num_rows == 1) {
            $usuario = $sql_query->fetch_assoc();

            // Pega o hash da senha armazenada no banco de dados
            $hash_senha_banco = $usuario['senha_criptografada'];

            // Atualiza a senha criptografada sempre que houver um logout do usuario. 
            if (!empty($hash_senha_banco)) {
                // Gera o hash da senha
                $hash_senha = password_hash($senha, PASSWORD_DEFAULT);

                // SQL para atualizar a senha criptografada no banco de dados
                $sql_update = "UPDATE login SET senha_criptografada = '$hash_senha' WHERE id_login = " . $usuario['id_login'];
                $mysqli->query($sql_update) or die("Falha ao atualizar a senha criptografada: " . $mysqli->error);
            }

            // Verifica se a senha inserida corresponde ao hash armazenado
            if (password_verify($senha, $usuario['senha_criptografada'])) {
                if (!isset($_SESSION)) {
                    session_start();
                }

                // Armazena os dados do usuário na sessão
                $_SESSION['id'] = $usuario['id_login'];
                $_SESSION['nome'] = $usuario['nome_login'];

                // Redireciona para o painel
                header("Location: painel.php");
                exit(); // Encerra a execução após o redirecionamento
            } else {
                $erro = "Falha Ao Logar! NOME OU SENHA INVALIDOS!";
            }
        } else {
            $erro = "Falha Ao Logar! Usuário não encontrado!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-[#ebe7e0] flex items-center justify-center min-h-screen">

    <form action="" method="POST" class="bg-white p-6 rounded-lg shadow-md w-96">
        <h2 class="text-xl font-bold mb-4 text-center text-[#44749d]">Login</h2>

        <!-- Exibe a mensagem de erro se houver -->
        <?php if ($erro): ?>
            <div class="bg-red-500 text-white p-2 mb-4 rounded">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <div class="mb-4">
            <label for="nome" class="block text-sm font-medium text-gray-700">Nome:</label>
            <input type="text" id="nome" name="nome" required class="mt-1 p-2 border border-gray-300 rounded-md w-full">
        </div>
        <div class="mb-4">
            <label for="senha" class="block text-sm font-medium text-gray-700">Senha:</label>
            <input type="password" id="senha" name="senha" required class="mt-1 p-2 border border-gray-300 rounded-md w-full">
        </div>
        <div class="flex justify-between items-center">
            <button type="submit" style="background-color: #44749d; color: white;" class="w-full p-2 rounded-md hover:bg-[#365f7e] transition duration-200">Entrar</button>
        </div>
        <div class="text-center mt-4">
        <a href="index.php" class="text-sm text-[#44749d] hover:underline">Não Possuí Cadastro? Faça agora!</a>
    </div>
    </form>
</body>

</html>
