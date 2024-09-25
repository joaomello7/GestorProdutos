<?php
session_start();

// Verifica se a sessão está ativa e a destrói
if (isset($_SESSION['id'])) {
    session_destroy();
}

// Redireciona o usuário para a página de login (index.php)
header("Location: index.php");
exit();
?>
