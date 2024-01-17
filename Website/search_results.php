<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "id21772530_pedro", "Porto2323_", "id21772530_dbmovie");

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if (isset($_GET['searchTerm'])) {
    $searchTerm = $conn->real_escape_string($_GET['searchTerm']);

    // Consulta para pesquisar filmes com nomes que contenham o termo de pesquisa
    $query_search = "SELECT idMovie, name, imgMovie FROM movies WHERE approval = 1 AND name LIKE '%$searchTerm%'";
    $result_search = $conn->query($query_search);

    // Verifica se há resultados
    if ($result_search->num_rows > 0) {
        // Exibir resultados da pesquisa
        while ($row_movie = $result_search->fetch_assoc()) {
            echo "<form action='movie_details.php' method='post'>";
            echo "<input type='hidden' name='id' value='{$row_movie['idMovie']}'>";
            echo "<button type='submit' class='movie-button'>";
            echo "<img src='uploads/{$row_movie['imgMovie']}' alt='{$row_movie['name']}'>";
            echo "</button>";
            echo "</form>";
        }
    } else {
        echo "Nenhum filme encontrado.";
    }
}

$conn->close();
?>