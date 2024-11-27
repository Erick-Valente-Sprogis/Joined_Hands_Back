<?php
header('Content-Type: application/json');

// Lê os dados recebidos como JSON
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['nome_completo'], $data['email'], $data['senha'])) {
    echo json_encode(['message' => 'Dados incompletos!']);
    exit;
}

$nome = htmlspecialchars($data['nome_completo']);
$email = htmlspecialchars($data['email']);
$senha = password_hash($data['senha'], PASSWORD_DEFAULT);
$telefone = htmlspecialchars($data['telefone']);
$cep = htmlspecialchars($data['cep']);
$logradouro = htmlspecialchars($data['logradouro']);

try {
    // Conexão com o banco de dados SQLite
    $db = new PDO('jdbc:sqlite:C:\Users\erick\OneDrive\Área de Trabalho\Joined_Hands\database\joined_hands.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se o e-mail já está cadastrado
    $stmt = $db->prepare("SELECT id FROM usuarios WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['message' => 'E-mail já cadastrado.']);
        exit;
    }

    // Insere o usuário no banco de dados
    $stmt = $db->prepare("INSERT INTO usuarios (nome, email, senha, tel, cep, logd) VALUES (:nome, :email, :senha, :tel, :cep, :logd)");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':tel', $telefone);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':logd', $logradouro);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Cadastro realizado com sucesso!']);
    } else {
        echo json_encode(['message' => 'Erro ao realizar o cadastro.']);
    }
} catch (PDOException $e) {
    echo json_encode(['message' => 'Erro no banco de dados: ' . $e->getMessage()]);
}
