<?php
session_start();

$logged_in_username = $_SESSION['username'];

$conn = new mysqli("localhost", "root", "", "movitime");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obtém o caminho da foto atual
$stmt = $conn->prepare("SELECT imgProfile FROM users WHERE username = ?");
$stmt->bind_param("s", $logged_in_username);
$stmt->execute();
$stmt->bind_result($foto_atual);
$stmt->fetch();
$stmt->close();

if (isset($_POST['novoNome']) && isset($_POST['novoEmail'])) {
    $novoNome = $_POST['novoNome'];
    $novoEmail = $_POST['novoEmail'];
}

if (isset($_FILES['novaFoto']) && $_FILES['novaFoto']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/'; // Diretório para armazenar as fotos
    $foto_token = uniqid(); // Gera um token único para a foto
    $uploadFile = $uploadDir . $foto_token . '_' . basename($_FILES['novaFoto']['name']); // Adiciona o token ao nome do arquivo

    // Exclui a foto atual
    if (!empty($foto_atual) && file_exists($foto_atual)) {
        unlink($foto_atual);
    }

    // Move a nova foto para o diretório de upload
    if (move_uploaded_file($_FILES['novaFoto']['tmp_name'], $uploadFile)) {
        // Atualiza o caminho da nova foto de perfil no banco de dados
        $stmt = $conn->prepare("UPDATE users SET imgProfile = ? WHERE username = ?");
        $stmt->bind_param("ss", $uploadFile, $logged_in_username);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Falha no upload da foto.";
    }
}

// Redireciona de volta para a página de perfil
header("Location: profile.php");
exit();
?>
