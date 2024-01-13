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

// Consulta para obter as categorias da tabela categorys
$query_categories = "SELECT idCategory, name FROM categorys";
$result_categories = $conn->query($query_categories);

$categoriaId = $_POST['categoryId'];

// Consulta para obter as capas dos filmes da tabela movies com base no categoryId
$query_movies = "SELECT m.idMovie, m.name, m.imgMovie FROM movies m";

// Adiciona uma condição JOIN para a tabela moviecategory
if ($categoriaId !== null) {
    $query_movies .= " JOIN moviecategory mc ON m.idMovie = mc.idMovie WHERE mc.idCategory = $categoriaId";
}

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
    <style>
        .category-buttons {
            display: flex;
            justify-content: space-around; /* ou outro valor conforme necessário */
        }

        .category-button {
            /* Estilos adicionais para os botões, se necessário */
            margin: 5px; /* Espaçamento entre os botões */
        }
    </style>
</head>
<body>
    
<div class="sidemenu">
    <p><a href="indexLogin.php">Página Inicial</a></p>
    <p><a href="addMovies.php">Adicionar Filme/Série</a></p>
    <p><a href="calendario.php">Lançamentos</a></p>
    <p><a href="profile.php">Meu Perfil</a></p>
</div>

<div class="content-container">
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Pesquisar por Filme/Série...">
        <button onclick="searchMovies()">Pesquisar</button>
    </div>

    <div class="category-buttons">
    <?php
    // Exibe as categorias como botões/link
    while ($row_category = $result_categories->fetch_assoc()) {
        echo "<form action=\"categorias.php\" method=\"post\">";
        echo "<input type=\"hidden\" name=\"categoryId\" value=\"{$row_category['idCategory']}\">";
        echo "<button type=\"submit\" class=\"category-button\">";
        echo "{$row_category['name']}";
        echo "</button>";
        echo "</form>";
    }
    ?>
</div>

    <div class="movie-covers">
        <?php
        // Exibe as capas dos filmes como botões/link
        while ($row_movie = $result_movies->fetch_assoc()) {
            echo "<form action=\"movie_details.php\" method=\"post\">";
            echo "<input type=\"hidden\" name=\"id\" value=\"{$row_movie['idMovie']}\">";
            echo "<button type=\"submit\" class=\"movie-button\">";
            echo "<img src=\"uploads/{$row_movie['imgMovie']}\" alt=\"{$row_movie['name']}\">";
            echo "</button>";
            echo "</form>";
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
</script>

</body>
</html>
