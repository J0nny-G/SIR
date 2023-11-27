<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="addMovies.css">
    <title>Adicionar Filme/Série</title>
</head>
<body>

<div class="sidemenu">
    <p><a href="#">Página Inicial</a></p>
    <p><a href="addMovies.php">Adicionar Filme/Série</a></p>
    <p><a href="profile.php">Meu Perfil</a></p>
</div>

<div class="content-container profile-container">
    <!-- Adicione um título para o formulário -->
    <h2>Adicionar Novo Filme/Série</h2>

    <div class="form-container">
        <form action="processar_filme.php" method="post" enctype="multipart/form-data">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="genero">Gênero:</label>
            <input type="text" id="genero" name="genero" required>

            <label for="ano">Ano de Lançamento:</label>
            <input type="number" id="ano" name="ano" required>

            <label for="sinopse">Sinopse:</label>
            <textarea id="sinopse" name="sinopse" rows="4" required></textarea>

            <label for="capaFilme">Capa do Filme/Série:</label>
            <input type="file" id="capaFilme" name="capaFilme" accept="image/*" required>

            <button type="submit">Adicionar Filme/Série</button>
        </form>
    </div>
</div>

<!-- Adicione seu script JavaScript aqui, se necessário -->

</body>
</html>
