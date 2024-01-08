<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="movieDetails.css">
    <title>Detalhes do Filme/Série</title>
</head>
<body>

<div class="content-container">
<?php
session_start();

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "movitime");

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Obtém o ID do filme do formulário POST
$movieId = $_POST['id'];

// Consulta para obter informações detalhadas do filme
$query_movie_details = "SELECT * FROM movies WHERE idMovie = $movieId";
$result_movie_details = $conn->query($query_movie_details);

// Fecha a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="movieDetails.css">
    <title>Detalhes do Filme/Série</title>
</head>
<body>

<div class="content-container">
    <?php
    // Exibe as informações detalhadas do filme
    while ($row_movie_details = $result_movie_details->fetch_assoc()) {
        echo "<h2>{$row_movie_details['name']}</h2>";
        echo "<p>{$row_movie_details['description']}</p>";
        echo "<p>{$row_movie_details['duration']}</p>";
        echo "<p>{$row_movie_details['releaseYear']}</p>";
        echo "<img src=\"uploads/{$row_movie_details['imgMovie']}\" alt=\"{$row_movie_details['name']}\">";
        
        // Adiciona o vídeo do YouTube
        $link = $row_movie_details['trail'];
        echo "<div class=\"youtube-container\">";
        if (!empty($link)) {
            $videoId = getYouTubeVideoId($link);
            echo "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/$videoId\" title=\"YouTube video player\" frameborder=\"0\" allowfullscreen></iframe>";
        } else {
            echo "<p>Nenhum vídeo disponível.</p>";
        }
        echo "</div>";
    }
    ?>

</div>

</body>
</html>

<?php
function getYouTubeVideoId($url) {
    $videoId = '';
    $pattern = '/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
    preg_match($pattern, $url, $matches);
    if (isset($matches[1])) {
        $videoId = $matches[1];
    }
    return $videoId;
}
?>
