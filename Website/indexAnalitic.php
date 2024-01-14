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

$user = 5;
$admin = 1;
$taster = 2;
$analyst = 6;

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

?>

<div style="width: 80%; margin: auto;">
    <div class="canvas-container">
        <canvas id="userChart"></canvas>
    </div>
    <div class="canvas-container">
        <canvas id="movieChart"></canvas>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Dados fictícios (substitua pelos dados reais do seu banco de dados)
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
                data: [80, 20], // Substitua pelos dados reais
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
    });
</script>


</body>
</html>
