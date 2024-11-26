<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new PDO('sqlite:joined_hands.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Captura os dados do formulário
        $nome = htmlspecialchars($_POST['nome']);
        $email = htmlspecialchars($_POST['email']);
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografa a senha

        // Insere o usuário no banco de dados
        $stmt = $db->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();

        echo "Usuário cadastrado com sucesso!";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "O e-mail já está cadastrado.";
        } else {
            echo "Erro ao cadastrar usuário: " . $e->getMessage();
        }
    }
}
