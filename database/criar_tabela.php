<?php
try {
    // Conexão com o banco de dados
    $db = new PDO('sqlite:C:\Users\erick\OneDrive\Área de Trabalho\Joined_Hands\database\joined_hands.db'); // Ajuste o caminho caso necessário
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Criação da tabela 'usuarios'
    $query = "CREATE TABLE IF NOT EXISTS usuarios (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        email TEXT UNIQUE NOT NULL,
        senha TEXT NOT NULL
    )";
    $db->exec($query);
    echo "Tabela 'usuarios' criada com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao criar a tabela: " . $e->getMessage();
}
