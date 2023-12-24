<?php
// Verificação do formulário de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenção dos dados do formulário
    $username = $_POST["username"];
    $password = $_POST["password"];
    $name = $_POST["name"];
    $email = $_POST["email"];

    // Conectar ao banco de dados (substitua com suas próprias credenciais)
    $conn = new mysqli("localhost", "root", "", "movitime");

    // Verificar a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Verificar se o nome de usuário já existe
    $check_username_query = "SELECT * FROM users WHERE username = ?";
    $check_username_stmt = $conn->prepare($check_username_query);
    $check_username_stmt->bind_param("s", $username);
    $check_username_stmt->execute();
    $check_username_result = $check_username_stmt->get_result();
    
    if ($check_username_result->num_rows > 0) {
        // Se o nome de usuário já existir, exiba uma mensagem de erro
        echo "<script>alert('O nome de usuário já existe. Escolha outro.'); window.location.href = 'register.html';</script>";
    } else {
        // Se o nome de usuário não existir, continue com a inserção na tabela
        // Hash da senha (usando algoritmo bcrypt)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Inserir os dados na tabela 'usuarios'
        $insert_query = "INSERT INTO users (username, password, nameUser, email) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("ssss", $username, $hashed_password, $name, $email);

        if ($insert_stmt->execute()) {
            echo "<script>alert('Conta criada com sucesso!'); window.location.href = 'login.html';</script>";
        } else {
            echo "<script>alert('Ocorreu um erro ao registrar sua conta, por favor tente mais tarde.'); window.location.href = 'index.html';</script>";
        }

        // Fechar a conexão com o banco de dados
        $insert_stmt->close();
    }

    // Fechar a conexão com o banco de dados
    $check_username_stmt->close();
    $conn->close();
}
?>
