<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Conexão com o banco de dados
        $db = new PDO('sqlite:../database/joined_hands.db'); // Ajuste o caminho se necessário
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Captura os dados do formulário
        $email = htmlspecialchars($_POST['email']);
        $senha = $_POST['senha'];

        // Verifica se o e-mail existe no banco de dados
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            session_start();
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_name'] = $usuario['nome'];
            header('Location: ../index.php'); // Redireciona para a página inicial
        } else {
            echo "E-mail ou senha incorretos.";
        }
    } catch (PDOException $e) {
        echo "Erro ao realizar login: " . $e->getMessage();
    }
}
