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
$conn = new mysqli("localhost", "id21772530_pedro", "Porto2323_", "id21772530_dbmovie");

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

$query_comments = "SELECT coments.idUser, coments.coment, coments.classificacao, users.imgProfile FROM coments INNER JOIN users ON coments.idUser = users.idUser WHERE coments.idMovie = $movieId";
$result_comments = $conn->query($query_comments);

$average_rating = 0;
$total_ratings = 0;

$comments_data = [];
while ($row_comment = $result_comments->fetch_assoc()) {
    $comments_data[] = $row_comment; // Correção aqui
    $total_ratings += isset($row_comment['classificacao']) ? $row_comment['classificacao'] : 0;
}

if ($result_comments->num_rows > 0) {
    $average_rating = $total_ratings / $result_comments->num_rows;
}

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
        foreach($comments_data as $row_coments_details)
            echo "<div class='movie-details'>";
            echo "  <img src=\"uploads/{$row_movie_details['imgMovie']}\" alt=\"{$row_movie_details['name']}\">";
            echo "  <div class='movie-info'>";
            echo "    <p><strong>Titulo:</strong> {$row_movie_details['name']}</p>";
            echo "    <p><strong>Duração:</strong> {$row_movie_details['duration']} minutos</p>";
            echo "    <p><strong>Ano de Lançamento:</strong> {$row_movie_details['releaseYear']}</p>";
            echo "    <p><strong>Descrição:</strong> {$row_movie_details['description']}</p>";
            echo "    <p><strong>Classificação:</strong> " . number_format($average_rating) . "</p>";

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
            echo "<form action='adicionar_comentario.php' method='post'>";
            echo "    <input type='hidden' name='id' value='$movieId'>";
            echo "    <textarea name='comment' rows='4' placeholder='Adicione seu comentário'></textarea>";
            echo "    <div class='rating'>";
            echo "        <input type='radio' id='star5' name='rating' value='5'><label for='star5'></label>";
            echo "        <input type='radio' id='star4' name='rating' value='4'><label for='star4'></label>";
            echo "        <input type='radio' id='star3' name='rating' value='3'><label for='star3'></label>";
            echo "        <input type='radio' id='star2' name='rating' value='2'><label for='star2'></label>";
            echo "        <input type='radio' id='star1' name='rating' value='1'><label for='star1'></label>";
            echo "    </div>";
            echo "    <button type='submit'>Adicionar Comentário</button>";
            echo "</form>";
            echo "</div>";

            // Exibição de Comentários Armazenados no Base de Dados
            $query_comments = "SELECT coments.idUser, coments.coment, coments.classificacao, users.imgProfile FROM coments INNER JOIN users ON coments.idUser = users.idUser WHERE coments.idMovie = $movieId";
            $result_comments = $conn->query($query_comments);

            if ($result_comments->num_rows > 0) {
                echo "<div class='all-comments'>";
                while ($row_comment = $result_comments->fetch_assoc()) {
                    echo "<div class='comment'>";
                    echo "  <div class='user-profile'>";
                    echo "      <img src=\"{$row_comment['imgProfile']}\" alt='Imagem de Perfil'>";
                    echo "  </div>";
                    echo "  <div class='comment-content'>";
                    echo "      <p>{$row_comment['coment']}</p>";
                    echo "      <p><strong>Classificação: </strong>" . (isset($row_comment['classificacao']) ? $row_comment['classificacao'] : 'Não classificado') . " &#9733;</p>";    
                    echo "  </div>"; 
                    echo "</div>";
                }
                echo "</div>";
            }
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