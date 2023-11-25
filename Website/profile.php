<?php
session_start(); // Inicia a sessão

// Verifica se a sessão está iniciada
if (!isset($_SESSION['username'])) {
    // Se a sessão não estiver iniciada, redireciona para a página de login
    header("Location: login.html");
    exit();
}

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

$stmt = $conn->prepare("SELECT imgProfile FROM users WHERE username = ?");
$stmt->bind_param("s", $logged_in_username);
$stmt->execute();
$stmt->bind_result($user_img);

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
    <title>Perfil</title>
</head>
<body>

<div class="sidemenu">
    <!-- Adicione links ou itens do sidemenu conforme necessário -->
    <p><a href="#">Página Inicial</a></p>
    <p><a href="#">Adicionar Filme/Série</a></p>
    <p><a href="#">Meu Perfil</a></p>
</div>

<div class="profile-container">
    <div class="profile-image">
        <img src="<?php echo $user_img ?>" alt="Imagem de Perfil">
    </div>
    <div class="user-info">
        <p><strong>Nome:</strong> <?php echo $user_name ?></p>
        <p><strong>Username:</strong> <?php echo $logged_in_username ?></p>
        <p><strong>Email:</strong> <?php echo $user_email ?></p>
    </div>

    <div class="buttons">
        <button onclick="mostrarFormularioEdicao()">Editar Perfil</button>
        <button onclick="terminarSessao()">Terminar Sessão</button>
        <button onclick="eliminarConta()">Eliminar Conta</button>
    </div>

    <!-- Formulário de edição (inicialmente oculto) -->
    <form id="formEdicao" style="display: none;" action="updateProfile.php" method="post" enctype="multipart/form-data">
        <label for="novoNome">Novo Nome:</label>
        <input type="text" id="novoNome" name="novoNome" value="<?php echo $user_name; ?>" required>

        <label for="novoEmail">Novo Email:</label>
        <input type="email" id="novoEmail" name="novoEmail" value="<?php echo $user_email; ?>" required>

        <label for="novaFoto">Nova Foto de Perfil:</label>
        <input type="file" id="novaFoto" name="novaFoto">

        <button type="submit">Salvar Alterações</button>
    </form>
</div>

<script>
    function mostrarFormularioEdicao() {
        document.getElementById("formEdicao").style.display = "block";
    }

    function terminarSessao() {
        window.location.href = 'logout.php';
    }

    function eliminarConta() {
        window.location.href = 'deleteAccount.php';
    }
</script>

</body>
</html>