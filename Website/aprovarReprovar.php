<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "id21772530_pedro", "Porto2323_", "id21772530_dbmovie");

    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    $idMovie = $_POST['idMovie'];

    if (isset($_POST['aprovar'])) {
        // Aprovar o filme (atualizar o campo approval para 1)
        $query = "UPDATE movies SET approval = 1 WHERE idMovie = $idMovie";
        $conn->query($query);
    } elseif (isset($_POST['reprovar'])) {
        // Exclua registros relacionados na tabela moviecategory
        $sqlDeleteMovieCategory = "DELETE FROM moviecategory WHERE idMovie = $idMovie";
        $conn->query($sqlDeleteMovieCategory);

        // Agora você pode excluir o filme da tabela movies
        $sqlDeleteMovie = "DELETE FROM movies WHERE idMovie = $idMovie";
        $conn->query($sqlDeleteMovie);
    }

    $conn->close();

    // Redirecionar de volta para a página de filmes pendentes de aprovação
    header("Location: filmesPendentes.php");
    exit();
} else {
    // Se não for um pedido POST, redirecionar de volta para a página inicial
    header("Location: index.php");
    exit();
}
?>
