<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $conn = new mysqli("localhost", "root", "", "movitime");

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Obtém o caminho da foto de perfil
    $stmt = $conn->prepare("SELECT imgProfile FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($foto_path);
    $stmt->fetch();
    $stmt->close();

    // Exclui o usuário da base de dados
    $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->close();

    // Exclui a foto de perfil se existir
    if (!empty($foto_path) && file_exists($foto_path)) {
        unlink($foto_path);
    }

    // Termina a sessão após excluir a conta
    session_destroy();
    
    // Redireciona para a página inicial
    header("Location: index.html");
    exit();
} else {
    // Se a sessão não estiver iniciada, redireciona para a página de login ou outra página apropriada
    header("Location: login.php");
    exit();
}
?>
