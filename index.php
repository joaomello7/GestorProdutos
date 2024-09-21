<?php
include("conexao.php");

$erro = ''; // Inicializa uma variável para armazenar a mensagem de erro

if (isset($_POST["nome"]) || isset($_POST["senha"])) {
    if (strlen($_POST["nome"]) == 0) {
        $erro = 'Preencha Seu Nome De Usuario!';
    } else if (strlen($_POST["senha"]) == 0) {
        $erro = 'Preencha Sua Senha!';
    } else {
        // Escapa os dados de entrada
        $nome = $mysqli->real_escape_string($_POST['nome']);
        $senha = $mysqli->real_escape_string($_POST['senha']);


        // Defina a senha do usuário principal
        $senha = 'minha_senha_secreta';
        
        // Gera o hash SHA-256 da senha
        $hash_senha = hash('sha256', $senha);
    
        

        // SQL para selecionar o usuário com a senha hash
        $sql_code = "SELECT * FROM login WHERE nome_login = '$nome' AND senha_login = '$hash_senha'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na Execução do Código SQL: " . $mysqli->error);

        $quantidade = $sql_query->num_rows;

        if ($quantidade == 1) {
            $usuario = $sql_query->fetch_assoc();

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
