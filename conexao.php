<?php  
$host = "localhost";
$user = "root";
$pass = "";
$db = "gerenciadordb";

// Conexão inicial sem selecionar banco de dados
$mysqli = new mysqli($host, $user, $pass);

// Verifica a conexão inicial
if ($mysqli->connect_errno) {
    echo("Conexão Falhou!: " . $mysqli->connect_error); 
    die();
}

// Criação do banco de dados se não existir
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $db";
if (!$mysqli->query($sql_create_db)) {
    echo "Erro ao criar banco de dados: " . $mysqli->error;
    die();
}

// Seleciona o banco de dados
$mysqli->select_db($db);

// Verifica a seleção do banco de dados
if ($mysqli->errno) {
    echo "Erro ao selecionar banco de dados: " . $mysqli->error;
    die();
}

// Criação automática das tabelas

// Tabela 'login'
$sql_login = "CREATE TABLE IF NOT EXISTS login (
    id_login INT AUTO_INCREMENT PRIMARY KEY,
    nome_login VARCHAR(100) NOT NULL,
    senha_login VARCHAR(255) NOT NULL,
    senha_criptografada VARCHAR(255) NOT NULL
)";

if (!$mysqli->query($sql_login)) {
    echo "Erro ao criar tabela 'login': " . $mysqli->error;
    die();
}

// Tabela 'fornecedores'
$sql_fornecedores = "CREATE TABLE IF NOT EXISTS fornecedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    empresa VARCHAR(100) NOT NULL,
    contato VARCHAR(15) NOT NULL
)";

if (!$mysqli->query($sql_fornecedores)) {
    echo "Erro ao criar tabela 'fornecedores': " . $mysqli->error;
    die();
}

// Tabela 'produtos'
$sql_produtos = "CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    quantidade INT NOT NULL,
    total DECIMAL(10, 2) AS (valor * quantidade) STORED,
    fornecedor_id INT NOT NULL,
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (fornecedor_id) REFERENCES fornecedores(id)
)";

if (!$mysqli->query($sql_produtos)) {
    echo "Erro ao criar tabela 'produtos': " . $mysqli->error;
    die();
}
?>
