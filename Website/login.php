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
        $conn = new mysqli("localhost", "id21772530_pedro", "Porto2323_", "id21772530_dbmovie");

        // Verificar a conexão
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // Consulta SQL para obter a senha hash e idLoads
        $stmt = $conn->prepare("SELECT password, idLoads FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password, $idLoads);
            $stmt->fetch();

            // Verificar se a senha está correta
            if (password_verify($password, $hashed_password)) {
                // Armazenar o username na sessão
                $_SESSION['username'] = $username;

                // Redirecionar com base no valor de idLoads
                if ($idLoads == 1) {
                    header('Location: adminIndex.php');
                } elseif ($idLoads == 2) {
                    header('Location: filmesPendentes.php');
                } elseif ($idLoads == 5) {
                    header('Location: profile.php');
                } elseif($idLoads == 6){
                    header('Location: indexAnalitic.php');
                } else {
                    // Valor desconhecido de idLoads
                    echo "Valor desconhecido de idLoads.";
                }

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
