<?php
session_start();

// Verifica se a sessão está iniciada
if (!isset($_SESSION['username'])) {
    // Se a sessão não estiver iniciada, redireciona para a página de login
    header("Location: login.html");
    exit();
}

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "movitime");

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Obtém o ID do usuário logado
$username = $_SESSION['username'];
$query_user_id = "SELECT idUser FROM users WHERE username = '$username'";
$result_user_id = $conn->query($query_user_id);

if ($result_user_id->num_rows > 0) {
    $row_user_id = $result_user_id->fetch_assoc();
    $idUser = $row_user_id['idUser'];
} else {
    echo "Erro ao obter o ID do usuário.";
    exit();
}

// Obtém o ID do filme do formulário POST
$movieId = $_POST['id'];

// Certifique-se de verificar se o ID do filme está presente
if ($movieId === null) {
    echo "ID do filme ausente.";
    exit();
}

// Obtém o comentario do formulário POST
$comment = $_POST['comment'];

// Obtém a classificação do formulário POST
$classificacao = $_POST['rating'];

// Insere o comentário na tabela comments
$insert_query = "INSERT INTO coments (idUser, idMovie, coment, classificacao) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("iisi", $idUser, $movieId, $comment, $classificacao);

        if ($insert_stmt->execute()) {
            echo "<script>alert('Comentario criado com sucesso!'); window.location.href = 'indexLogin.php';</script>";
        } else {
            echo "<script>alert('Ocorreu um erro ao registrar sua conta, por favor tente mais tarde.'); window.location.href = 'indexLogin.php';</script>";
        }

        // Fechar a conexão com o banco de dados
        $insert_stmt->close();

// Fecha a conexão com o banco de dados
$conn->close();
?>