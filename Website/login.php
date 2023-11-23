<?php
session_start(); // Inicia a sessão

// Verificação do formulário de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar se os campos foram preenchidos
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        echo "Por favor, preencha todos os campos.";
    } else {
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Conectar ao banco de dados (substitua com suas próprias credenciais)
        $conn = new mysqli("localhost", "root", "", "movitime");

        // Verificar a conexão
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // Consulta SQL para obter a senha hash
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();  // Importante: armazena o resultado antes de fazer o bind_result

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // Verificar se a senha está correta
            if (password_verify($password, $hashed_password)) {
                // Armazenar o username na sessão
                $_SESSION['username'] = $username;
                // Redirecionar para a página profile.php
                header('Location: profile.php');
                exit();
            } else {
                // Mensagem de erro
                echo "<script>alert('Credenciais inválidas.'); window.location.href = 'login.html';</script>";
            }
        } else {
            // Mensagem de erro
            echo "<script>alert('Credenciais inválidas.'); window.location.href = 'login.html';</script>";
        }

        $stmt->close();
        $conn->close();
    }
}
?>