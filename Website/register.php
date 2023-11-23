<?php
// Verificação do formulário de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenção dos dados do formulário
    $username = $_POST["username"];
    $password = $_POST["password"];
    $name = $_POST["name"];
    $email = $_POST["email"];

    // Hash da senha (usando algoritmo bcrypt)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Conectar ao banco de dados (substitua com suas próprias credenciais)
    $conn = new mysqli("localhost", "root", "", "movitime");

    // Verificar a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Inserir os dados na tabela 'usuarios'
    $stmt = $conn->prepare("INSERT INTO users (username, password, name, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $hashed_password, $name, $email);

    if ($stmt->execute()) {
        echo "Novo usuário registrado com sucesso!";
    } else {
        echo "Erro ao registrar novo usuário. Tente novamente.";
    }

    // Fechar a conexão com o banco de dados
    $stmt->close();
    $conn->close();
}
?>
