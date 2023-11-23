<?php
session_start(); // Inicia a sessão


$logged_in_username = $_SESSION['username'];

$conn = new mysqli("localhost", "root", "", "movitime");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta SQL para obter o nome correspondente ao username
$stmt = $conn->prepare("SELECT name FROM users WHERE username = ?");
$stmt->bind_param("s", $logged_in_username);
$stmt->execute();
$stmt->bind_result($user_name);

// Obtém o resultado da consulta
$stmt->fetch();
$stmt->close();

$stmt = $conn->prepare("SELECT email FROM users WHERE username = ?");
$stmt->bind_param("s", $logged_in_username);
$stmt->execute();
$stmt->bind_result($user_email);

// Obtém o resultado da consulta
$stmt->fetch();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="perfil.css">
    <title>Perfil do Usuário</title>
</head>
<body>

<div class="sidemenu">
    <!-- Adicione links ou itens do sidemenu conforme necessário -->
    <p><a href="#">Página Inicial</a></p>
    <p><a href="#">Configurações</a></p>
    <p><a href="#">Ajuda</a></p>
</div>

<div class="profile-container">
    <div class="profile-image">
        <img src="img/pedro.jpg" alt="Imagem de Perfil">
    </div>
    <div class="user-info">
        <p><strong>Nome:</strong> <?php echo $user_name ?></p>
        <p><strong>Username:</strong> <?php echo $logged_in_username ?></p>
        <p><strong>Email:</strong> <?php echo $user_email ?></p>
    </div>

    <div class="buttons">
        <button onclick="editarPerfil()">Editar</button>
        <button onclick="terminarSessao()">Terminar Sessão</button>
        <button onclick="eliminarConta()">Eliminar Conta</button>
    </div>
</div>

<script>
    function editarPerfil() {
        // Adicione a lógica para editar o perfil aqui
        alert('Editar perfil');
    }

    function terminarSessao() {
        // Adicione a lógica para terminar a sessão aqui
        alert('Terminar Sessão');
    }

    function eliminarConta() {
        // Adicione a lógica para excluir a conta aqui
        alert('Eliminar Conta');
    }
</script>

</body>
</html>
