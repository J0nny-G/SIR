<?php
session_start();

// Verifica se a sessão está iniciada
if (!isset($_SESSION['username'])) {
    // Se a sessão não estiver iniciada, redireciona para a página de login
    header("Location: login.html");
    exit();
}

$logged_in_username = $_SESSION['username'];

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

$stmt = $conn->prepare("SELECT imgProfile FROM users WHERE username = ?");
$stmt->bind_param("s", $logged_in_username);
$stmt->execute();
$stmt->bind_result($user_img);

// Fecha a conexão com o banco de dados
$stmt->fetch();
$stmt->close();
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
        echo "<div class='movie-details'>";
        echo "  <img src=\"uploads/{$row_movie_details['imgMovie']}\" alt=\"{$row_movie_details['name']}\">";
        echo "  <div class='movie-info'>";
        echo "    <p><strong>Titulo:</strong> {$row_movie_details['name']}</p>";
        echo "    <p><strong>Duração:</strong> {$row_movie_details['duration']} minutos</p>";
        echo "    <p><strong>Ano de Lançamento:</strong> {$row_movie_details['releaseYear']}</p>";
        echo "    <p><strong>Descrição:</strong> {$row_movie_details['description']}</p>";
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
        echo "  </div>";
        echo "</div>";

        // Seção de Comentários e Imagem de Perfil
        echo "<div class='comments-section'>";
        // Imagem de Perfil
        echo "  <div class='user-profile'>";
        echo "      <img src=\"$user_img\" alt='Imagem de Perfil'>";
        echo "  </div>";
        // Caixa de Comentários
        echo "  <form action='adicionar_comentario.php' method='post'>";
        echo "      <input type='hidden' name='id' value='$movieId'>";
        echo "      <textarea name='comment' rows='4' placeholder='Adicione seu comentário'></textarea>";
        echo "      <button type='submit'>Adicionar Comentário</button>";
        echo "  </form>";

        // Exibição de Comentários Armazenados no Banco de Dados
        $query_comments = "SELECT coments.idUser, coments.coment, users.imgProfile FROM coments INNER JOIN users ON coments.idUser = users.idUser WHERE coments.idMovie = $movieId";
        $result_comments = $conn->query($query_comments);

        if ($result_comments->num_rows > 0) {
            echo "<div class='all-comments'>";
            while ($row_comment = $result_comments->fetch_assoc()) {
                echo "<div class='comment'>";
                echo "  <div class='user-profile'>";
                echo "      <img src=\"{$row_comment['imgProfile']}\" alt='Imagem de Perfil'>";
                echo "  </div>";
                echo "  <p>{$row_comment['coment']}</p>";
                echo "</div>";
            }
            echo "</div>";
        }

        echo "</div>"; // Fechamento da div 'comments-section'
    }
    $conn->close();
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
