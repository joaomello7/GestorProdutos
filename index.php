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
    <link rel="stylesheet" href="styles/cadastro.css"> <!-- Vinculando o CSS externo -->
</head>

<body>

    <form action="" method="POST">
        <h2>Cadastro</h2>

        <!-- Exibe a mensagem de erro ou sucesso -->
        <?php if ($erro): ?>
            <div class="message">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo isset($_POST['nome']) ? $_POST['nome'] : ''; ?>" required>
        </div>
        <div>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <div>
            <button type="submit">Cadastrar</button>
        </div>

        <div class="link-login">
            <a href="login.php">Já possui uma conta? Faça login!</a>
        </div>
    </form>

</body>

</html>
