<?php
session_start();

// Conexão com a base de dados
$conn = new mysqli("localhost", "root", "", "movitime");

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para obter os gêneros da tabela categorys
$query = "SELECT idCategory, name FROM categorys";
$result = $conn->query($query);

// Array para armazenar os gêneros
$generos = [];

// Preenche o array com os gêneros obtidos da consulta
while ($row = $result->fetch_assoc()) {
    $generos[] = [
        'idCategory' => $row['idCategory'],
        'name' => $row['name']
    ];
}

// Fecha a conexão com o banco de dados
$conn->close();
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
    <p><a href="indexLogin.php">Página Inicial</a></p>
    <p><a href="addMovies.php">Adicionar Filme/Série</a></p>
    <p><a href="profile.php">Meu Perfil</a></p>
</div>

<div class="content-container profile-container">
    <!-- Adicione um título para o formulário -->
    <h2>Adicionar Novo Filme/Série</h2>

    <div class="form-container">
        <form action="newMovie.php" method="post" enctype="multipart/form-data">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="genero">Gênero:</label>
            <!-- Use um menu suspenso (select) para os gêneros -->
            <select id="genero" name="genero" required>
                <?php
                // Exibe as opções de gênero no menu suspenso
                foreach ($generos as $genero) {
                    echo "<option value=\"{$genero['idCategory']}\">{$genero['name']}</option>";
                }
                ?>
            </select>

            <label for="ano">Ano de Lançamento:</label>
            <input type="text" id="ano" name="ano" required>

            <label for="">Duração:</label>
            <input type="number" id="duracao" name="duracao" required>

            <label for="sinopse">Sinopse:</label>
            <textarea id="sinopse" name="sinopse" rows="4" required></textarea>

            <label for="capaFilme">Capa do Filme/Série:</label>
            <input type="file" id="capaFilme" name="capaFilme" accept="image/*" required>

            <button type="submit">Adicionar Filme/Série</button>
        </form>
    </div>
</div>

</body>
</html>
