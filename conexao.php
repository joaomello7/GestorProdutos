<?php  
$host = "localhost";
$user = "root";
$pass = "";
$db = "gerenciadordb";

$mysqli = new mysqli($host, $user, $pass, $db);

// Verifica a conexão
if ($mysqli->connect_errno) {
    echo("Conexão Falhou!: " . $mysqli->connect_error); 
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
