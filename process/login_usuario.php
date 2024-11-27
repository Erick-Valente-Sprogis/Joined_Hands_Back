<?php
session_start();  // Inicia a sessão para armazenar dados do usuário
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permite requisições de outros domínios (apenas para desenvolvimento)
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Conexão com o banco de dados
        $db = new PDO('sqlite:C:/Users/erick/OneDrive/Área de Trabalho/Joined_Hands/database/joined_hands.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Captura os dados enviados via Fetch API
        $data = json_decode(file_get_contents('php://input'), true);
        $email = htmlspecialchars($data['email']);
        $senha = $data['senha'];

        // Verifica se o e-mail está cadastrado no banco de dados
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['user_id'] = $usuario['id'];  // ID do usuário
            $_SESSION['user_name'] = $usuario['nome'];  // Nome do usuário
            echo json_encode([
                'status' => 'success',
                'message' => 'Login realizado com sucesso!',
                'user_name' => $usuario['nome']
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'E-mail ou senha inválidos!'
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Erro ao realizar login: ' . $e->getMessage()
        ]);
    }
} else {
    // Resposta caso o método HTTP não seja POST
    echo json_encode([
        'status' => 'error',
        'message' => 'Método HTTP inválido.'
    ]);
}
