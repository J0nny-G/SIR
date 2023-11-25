<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $conn = new mysqli("localhost", "root", "", "movitime");

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->close();

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
