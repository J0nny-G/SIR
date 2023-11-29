<?php
session_start();

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "movitime");

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para obter as categorias da tabela categorys
$query_categories = "SELECT idCategory, name FROM categorys";
$result_categories = $conn->query($query_categories);

// Consulta para obter as capas dos filmes da tabela movies
$query_movies = "SELECT idMovie, name, imgMovie FROM movies";
$result_movies = $conn->query($query_movies);

// Fecha a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="searchMovies.css">
    <title>Pesquisar Filmes/Séries</title>
</head>
<body>
    
<div class="sidemenu">
    <p><a href="#">Página Inicial</a></p>
    <p><a href="addMovies.php">Adicionar Filme/Série</a></p>
    <p><a href="profile.php">Meu Perfil</a></p>
</div>

<div class="content-container">
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Pesquisar por nome...">
        <button onclick="searchMovies()">Pesquisar</button>
    </div>

    <div class="category-buttons">
        <?php
        // Exibe os botões das categorias
        while ($row_category = $result_categories->fetch_assoc()) {
            echo "<button onclick=\"filterByCategory({$row_category['idCategory']})\">{$row_category['name']}</button>";
        }
        ?>
    </div>

    <div class="movie-covers">
        <?php
        // Exibe as capas dos filmes
        while ($row_movie = $result_movies->fetch_assoc()) {
            echo "<img src=\"uploads/{$row_movie['imgMovie']}\" alt=\"{$row_movie['name']}\">";
        }
        ?>
    </div>
</div>

<script>
    function searchMovies() {
        var searchTerm = document.getElementById('searchInput').value;
        // Implemente a lógica de pesquisa aqui
        alert('Pesquisar por: ' + searchTerm);
    }

    function filterByCategory(categoryId) {
        // Implemente a lógica de filtragem por categoria aqui
        alert('Filtrar por categoria ID: ' + categoryId);
    }
</script>

</body>
</html>
