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
        $senha = $_POST['senha']; // A senha em texto puro do formulário

        // SQL para selecionar o usuário pelo nome de login
        $sql_code = "SELECT * FROM login WHERE nome_login = '$nome'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na Execução do Código SQL: " . $mysqli->error);

        // Verifica se o usuário existe
        if ($sql_query->num_rows == 1) {
            $usuario = $sql_query->fetch_assoc();
            
            // Pega o hash da senha armazenada no banco de dados
            $hash_senha_banco = $usuario['senha_criptografada'];

            // Se a senha ainda não estiver hashada, cria o hash e atualiza no banco
            if (empty($hash_senha_banco)) {
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
    <link rel="stylesheet" href="styles/index.css"> <!-- Vinculando o CSS externo -->
</head>

<body>

    <form action="" method="POST">
        <h2>Login</h2>

        <!-- Exibe a mensagem de erro se houver -->
        <?php if ($erro): ?>
            <div class="error-message">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        <div>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <div>
            <button type="submit">Entrar</button>
        </div>
    </form>

</body>

</html>
