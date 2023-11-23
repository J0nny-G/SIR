<?php
session_start(); // Inicia a sessão

$logged_in_username = $_SESSION['username'];

$conn = new mysqli("localhost", "root", "", "movitime");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o formulário de edição foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['novoNome'], $_POST['novoEmail'])) {
    // Obter os novos dados do formulário
    $novoNome = $_POST['novoNome'];
    $novoEmail = $_POST['novoEmail'];

    // Atualizar os dados na base de dados
    $atualizar_query = "UPDATE users SET name = ?, email = ? WHERE username = ?";
    $atualizar_stmt = $conn->prepare($atualizar_query);
    $atualizar_stmt->bind_param("sss", $novoNome, $novoEmail, $logged_in_username);

    if ($atualizar_stmt->execute()) {
        // Atualização bem-sucedida
        echo "<script>alert('Perfil atualizado com sucesso!'); window.location.href = 'profile.php';</script>";
    } else {
        // Mensagem de erro
        echo "<script>alert('Ocorreu um erro ao atualizar o perfil. Tente novamente mais tarde.'); window.location.href = 'profile.php';</script>";
    }

    $atualizar_stmt->close();
}

// Restante do código...
?>