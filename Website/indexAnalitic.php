<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="indexAnalitic.css">
    <title>Gráficos de Dados</title>
</head>
<body>

<?php

$conn = new mysqli("localhost","root","","movitime");

$idAprovados = 1;
$idAprovacao = 0;
$user = 5;
$admin = 1;
$taster = 2;
$analyst = 6;
$acao = 1;
$aventura = 2;
$acaoAventura = 3;
$drama = 4;
$comediaRomance = 5;
$ficaoCientifica = 6;
$terror = 7;
$comedia = 8;
$romance = 9;



// Total de users
$users = $conn->prepare("SELECT * FROM users WHERE idLoads = ?");
$users->bind_param("i", $user);
$users->execute();
$users->store_result();
$totalUsers = $users->num_rows;
$users->close();

// Total de admins
$admins = $conn->prepare("SELECT * FROM users WHERE idLoads = ?");
$admins->bind_param("i", $admin);
$admins->execute();
$admins->store_result();
$totalAdmins = $admins->num_rows;
$admins->close();

// Total de tasters
$tasters = $conn->prepare("SELECT * FROM users WHERE idLoads = ?");
$tasters->bind_param("i", $taster);
$tasters->execute();
$tasters->store_result();
$totalTasters = $tasters->num_rows;
$tasters->close();

// Total de analyst
$analysts = $conn->prepare("SELECT * FROM users WHERE idLoads = ?");
$analysts->bind_param("i", $analyst);
$analysts->execute();
$analysts->store_result();
$totalAnalysts = $analysts->num_rows;
$analysts->close();

// Obter filmes aprovados
$aprovados = $conn->prepare("SELECT * FROM movies WHERE approval = ?");
$aprovados->bind_param("i",$idAprovados);
$aprovados->execute();
$aprovados->store_result();
$totalAprovados = $aprovados->num_rows();
$aprovados->close();

// Obter filmes em aprovação
$aprovacao = $conn->prepare("SELECT * FROM movies WHERE approval = ?");
$aprovacao->bind_param("i",$idAprovacao);
$aprovacao->execute();
$aprovacao->store_result();
$totalAprovacao = $aprovacao->num_rows();
$aprovacao->close();

// Categoria Ação
$acaoquery = $conn->prepare("SELECT name FROM categorys WHERE idCategory = ?");
$acaoquery->bind_param("i", $acao);
$acaoquery->execute();
$acaoquery->bind_result($nameAcao);
$acaoquery->fetch();
$acaoquery->close();

// Categoria Aventura
$aventuraquery = $conn->prepare("SELECT name FROM categorys WHERE idCategory = ?");
$aventuraquery->bind_param("i", $aventura);
$aventuraquery->execute();
$aventuraquery->bind_result($nameAventura);
$aventuraquery->fetch();
$aventuraquery->close();

// Categoria Ação e Ventura
$acaoVenturaquery = $conn->prepare("SELECT name FROM categorys WHERE idCategory = ?");
$acaoVenturaquery->bind_param("i", $acaoAventura);
$acaoVenturaquery->execute();
$acaoVenturaquery->bind_result($nameAcaoAventura);
$acaoVenturaquery->fetch();
$acaoVenturaquery->close();

// Categoria Drama
$dramaquery = $conn->prepare("SELECT name FROM categorys WHERE idCategory = ?");
$dramaquery->bind_param("i", $drama);
$dramaquery->execute();
$dramaquery->bind_result($nameDrama);
$dramaquery->fetch();
$dramaquery->close();

// Categoria Comedia e Romance
$comediaRomancequery = $conn->prepare("SELECT name FROM categorys WHERE idCategory = ?");
$comediaRomancequery->bind_param("i", $comediaRomance);
$comediaRomancequery->execute();
$comediaRomancequery->bind_result($nameComediaRomance);
$comediaRomancequery->fetch();
$comediaRomancequery->close();

// Categoria Fiqueção Cientifica
$ficaoCientificaquery = $conn->prepare("SELECT name FROM categorys WHERE idCategory = ?");
$ficaoCientificaquery->bind_param("i", $ficaoCientifica);
$ficaoCientificaquery->execute();
$ficaoCientificaquery->bind_result($nameFicao);
$ficaoCientificaquery->fetch();
$ficaoCientificaquery->close();

// Categoria Terror
$terrorquery = $conn->prepare("SELECT name FROM categorys WHERE idCategory = ?");
$terrorquery->bind_param("i", $terror);
$terrorquery->execute();
$terrorquery->bind_result($nameTerror);
$terrorquery->fetch();
$terrorquery->close();

// Categoria Comedia
$comediaquery = $conn->prepare("SELECT name FROM categorys WHERE idCategory = ?");
$comediaquery->bind_param("i", $comedia);
$comediaquery->execute();
$comediaquery->bind_result($nameComedia);
$comediaquery->fetch();
$comediaquery->close();

// Categoria Romance
$romancequery = $conn->prepare("SELECT name FROM categorys WHERE idCategory = ?");
$romancequery->bind_param("i", $romance);
$romancequery->execute();
$romancequery->bind_result($nameRomance);
$romancequery->fetch();
$romancequery->close();

// Total de Comentarios da Categoria Ação
$acaoqueryTotal = $conn->prepare("SELECT COUNT(*) as total_comments FROM coments c JOIN moviecategory mc ON c.idMovie = mc.idMovie WHERE mc.idCategory = ?");
$acaoqueryTotal->bind_param("i", $acao);
$acaoqueryTotal->execute();
$acaoqueryTotal->bind_result($totalAcao);
$acaoqueryTotal->fetch();
$acaoqueryTotal->close();

// Total de Comentarios da Categoria Aventura
$aventuraqueryTotal = $conn->prepare("SELECT COUNT(*) as total_comments FROM coments c JOIN moviecategory mc ON c.idMovie = mc.idMovie WHERE mc.idCategory = ?");
$aventuraqueryTotal->bind_param("i", $aventura);
$aventuraqueryTotal->execute();
$aventuraqueryTotal->bind_result($totalAventura);
$aventuraqueryTotal->fetch();
$aventuraqueryTotal->close();

// Total de Comentarios da Categoria Ação e Aventura
$acaoaventuraqueryTotal = $conn->prepare("SELECT COUNT(*) as total_comments FROM coments c JOIN moviecategory mc ON c.idMovie = mc.idMovie WHERE mc.idCategory = ?");
$acaoaventuraqueryTotal->bind_param("i", $acaoAventura);
$acaoaventuraqueryTotal->execute();
$acaoaventuraqueryTotal->bind_result($totalAcaoAventura);
$acaoaventuraqueryTotal->fetch();
$acaoaventuraqueryTotal->close();

// Total de Comentarios da Categoria Drama
$dramaqueryTotal = $conn->prepare("SELECT COUNT(*) as total_comments FROM coments c JOIN moviecategory mc ON c.idMovie = mc.idMovie WHERE mc.idCategory = ?");
$dramaqueryTotal->bind_param("i", $drama);
$dramaqueryTotal->execute();
$dramaqueryTotal->bind_result($totalDrama);
$dramaqueryTotal->fetch();
$dramaqueryTotal->close();

// Total de Comentarios da Categoria Comedia e Romance
$comediaRomancequeryTotal = $conn->prepare("SELECT COUNT(*) as total_comments FROM coments c JOIN moviecategory mc ON c.idMovie = mc.idMovie WHERE mc.idCategory = ?");
$comediaRomancequeryTotal->bind_param("i", $comediaRomance);
$comediaRomancequeryTotal->execute();
$comediaRomancequeryTotal->bind_result($totalComediaRomance);
$comediaRomancequeryTotal->fetch();
$comediaRomancequeryTotal->close();

// Total de Comentarios da Categoria Ficção Cientifica
$ficcaoqueryTotal = $conn->prepare("SELECT COUNT(*) as total_comments FROM coments c JOIN moviecategory mc ON c.idMovie = mc.idMovie WHERE mc.idCategory = ?");
$ficcaoqueryTotal->bind_param("i", $ficaoCientifica);
$ficcaoqueryTotal->execute();
$ficcaoqueryTotal->bind_result($totalFiccao);
$ficcaoqueryTotal->fetch();
$ficcaoqueryTotal->close();

// Total de Comentarios da Categoria Terror
$terrorqueryTotal = $conn->prepare("SELECT COUNT(*) as total_comments FROM coments c JOIN moviecategory mc ON c.idMovie = mc.idMovie WHERE mc.idCategory = ?");
$terrorqueryTotal->bind_param("i", $terror);
$terrorqueryTotal->execute();
$terrorqueryTotal->bind_result($totalTerror);
$terrorqueryTotal->fetch();
$terrorqueryTotal->close();

// Total de Comentarios da Categoria Comedia
$comediaqueryTotal = $conn->prepare("SELECT COUNT(*) as total_comments FROM coments c JOIN moviecategory mc ON c.idMovie = mc.idMovie WHERE mc.idCategory = ?");
$comediaqueryTotal->bind_param("i", $comedia);
$comediaqueryTotal->execute();
$comediaqueryTotal->bind_result($totalComedia);
$comediaqueryTotal->fetch();
$comediaqueryTotal->close();

// Total de Comentarios da Categoria Romance
$romancequeryTotal = $conn->prepare("SELECT COUNT(*) as total_comments FROM coments c JOIN moviecategory mc ON c.idMovie = mc.idMovie WHERE mc.idCategory = ?");
$romancequeryTotal->bind_param("i", $romance);
$romancequeryTotal->execute();
$romancequeryTotal->bind_result($totalRomance);
$romancequeryTotal->fetch();
$romancequeryTotal->close();

$sql = "SELECT COUNT(mc.idMovie) as total_movies
        FROM categorys c
        LEFT JOIN moviecategory mc ON c.idCategory = mc.idCategory
        GROUP BY c.idCategory";

$result = $conn->query($sql);

if ($result) {
    // Processar os resultados
    while ($row = $result->fetch_assoc()) {
        $totalMovies = $row['total_movies'];
        $totalMoviesData[] = $totalMovies;
    }

    // Liberar resultado
    $result->free();
} else {
    // Tratar erro na consulta
    echo "Erro na consulta: " . $conn->error;
}

// Fechar conexão
$conn->close();
$totalMoviesAcao = isset($totalMoviesData[0]) ? $totalMoviesData[0] : 0;
$totalMoviesAventura = isset($totalMoviesData[1]) ? $totalMoviesData[1] : 0;
$totalMoviesAcaoAventura = isset($totalMoviesData[2]) ? $totalMoviesData[2] : 0;
$totalMoviesDrama = isset($totalMoviesData[3]) ? $totalMoviesData[3] : 0;
$totalMoviesComediaRomance = isset($totalMoviesData[4]) ? $totalMoviesData[4] : 0;
$totalMoviesFicao = isset($totalMoviesData[5]) ? $totalMoviesData[5] : 0;
$totalMoviesTerror = isset($totalMoviesData[6]) ? $totalMoviesData[6] : 0;
$totalMoviesComedia = isset($totalMoviesData[7]) ? $totalMoviesData[7] : 0;
$totalMoviesRomance = isset($totalMoviesData[8]) ? $totalMoviesData[8] : 0;

?>

<div style="width: 80%; margin: auto;">
    <div class="canvas-container">
        <canvas id="userChart"></canvas>
    </div>
    <div class="canvas-container">
        <canvas id="movieChart"></canvas>
    </div>
    <div class="canvas-container">
        <canvas id="categorysChart"></canvas>
    </div>
    <div class="canvas-container">
        <canvas id="filmesChart"></canvas>
    </div>
</div>
<div style="text-align: center; margin-top: 20px;">
    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var userData = {
            labels: ['User', 'Admin', 'Taster', 'Analyst'],
            datasets: [{
                label: 'Número de Tipos de Utilizadores Registrados',
                data: [<?php echo $totalUsers ?>, <?php echo $totalAdmins; ?>, <?php echo $totalTasters; ?>, <?php echo $totalAnalysts; ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        };

        var movieData = {
            labels: ['Aprovados', 'Em Aprovação'],
            datasets: [{
                label: 'Status dos Filmes',
                data: [<?php echo $totalAprovados ?>, <?php echo $totalAprovacao ?>],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(255, 99, 132, 0.5)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        };

        var categorysData = {
            labels: ['<?php echo $nameAcao ?>', '<?php echo $nameAventura ?>', '<?php echo $nameAcaoAventura ?>', '<?php echo $nameDrama ?>', '<?php echo $nameComediaRomance ?>', '<?php echo $nameFicao ?>', '<?php echo $nameTerror ?>', '<?php echo $nameComedia ?>', '<?php echo $nameRomance ?>'],
            datasets: [{
                label: 'Número de Comentarios por Categoria',
                data: [<?php echo $totalAcao ?>,<?php echo $totalAventura ?>,<?php echo $totalAcaoAventura ?>,<?php echo $totalDrama ?>,<?php echo $totalComediaRomance ?>,<?php echo $totalFiccao ?>,<?php echo $totalTerror ?>,<?php echo $totalComedia ?>,<?php echo $totalRomance ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        };

        var FilmesData = {
            labels: ['<?php echo $nameAcao ?>', '<?php echo $nameAventura ?>', '<?php echo $nameAcaoAventura ?>', '<?php echo $nameDrama ?>', '<?php echo $nameComediaRomance ?>', '<?php echo $nameFicao ?>', '<?php echo $nameTerror ?>', '<?php echo $nameComedia ?>', '<?php echo $nameRomance ?>'],
            datasets: [{
                label: 'Número de Filmes por Categoria',
                data: ['<?php echo $totalMoviesAcao ?>','<?php echo $totalMoviesAventura ?>','<?php echo $totalMoviesAcaoAventura ?>','<?php echo $totalMoviesDrama ?>','<?php echo $totalMoviesComediaRomance ?>','<?php echo $totalMoviesFicao ?>','<?php echo $totalMoviesTerror ?>','<?php echo $totalMoviesComedia ?>','<?php echo $totalMoviesRomance ?>'],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Configurações do gráfico
        var options = {
            responsive: true,
            maintainAspectRatio: false
        };

        // Renderizar os gráficos
        var userChartCanvas = document.getElementById('userChart').getContext('2d');
        new Chart(userChartCanvas, {
            type: 'bar',
            data: userData,
            options: options
        });

        var movieChartCanvas = document.getElementById('movieChart').getContext('2d');
        new Chart(movieChartCanvas, {
            type: 'pie',
            data: movieData,
            options: options
        });

        var categorysChartCanvas = document.getElementById('categorysChart').getContext('2d');
        new Chart(categorysChartCanvas, {
            type: 'bar',
            data: categorysData,
            options: options
        });
        var filmesChartCanvas = document.getElementById('filmesChart').getContext('2d');
        new Chart(filmesChartCanvas, {
            type: 'bar',
            data: FilmesData,
            options: options
        });
    });
</script>


</body>
</html>
