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

// Consulta para obter todos os filmes com approval igual a 0 e suas categorias
$query = "SELECT m.*, c.name AS genero FROM movies m
          JOIN moviecategory mc ON m.idMovie = mc.idMovie
          JOIN categorys c ON mc.idCategory = c.idCategory
          WHERE m.approval = 0";
$result = $conn->query($query);

// Fecha a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="filmesPendentes.css">
    <title>Filmes Pendentes de Aprovação</title>
</head>
<body>

<div class="content-container profile-container">
    <h2>Filmes Pendentes de Aprovação</h2>

    <table>
        <tr>
            <th>Título</th>
            <th>Gênero</th>
            <th>Ano de Lançamento</th>
            <th>Duração</th>
            <th>Sinopse</th>
            <th>Capa</th>
            <th>Trailer</th>
            <th>Ações</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['genero']; ?></td>
                <td><?php echo $row['releaseYear']; ?></td>
                <td><?php echo $row['duration']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><img src="uploads/<?php echo $row['imgMovie']; ?>" alt="Capa do Filme"></td>
                <td><?php echo $row['trail']; ?></td>
                <td>
                    <form method="post" action="aprovarReprovar.php">
                        <input type="hidden" name="idMovie" value="<?php echo $row['idMovie']; ?>">
                        <button type="submit" name="aprovar">Aprovar</button>
                        <button type="submit" name="reprovar">Reprovar</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Formulário de Logout -->
    <form method="post" action="logout.php" class="logout-form">
        <button type="submit">Logout</button>
    </form>

</div>

</body>
</html>
