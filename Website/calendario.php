<?php
// Conexão com o banco de dados (substitua as credenciais conforme necessário)
$conn = new mysqli("localhost", "id21772530_pedro", "Porto2323_", "id21772530_dbmovie");

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para obter eventos do banco de dados
$query_events = "SELECT id, title, start_date, description FROM events";
$result_events = $conn->query($query_events);

// Array para armazenar eventos
$events = array();

// Formata os resultados para o formato esperado pelo FullCalendar
while ($row = $result_events->fetch_assoc()) {
    $event = array(
        'id' => $row['id'],
        'title' => $row['title'],
        'start' => $row['start_date'],
        'description' => $row['description']
    );
    array_push($events, $event);
}

// Fecha a conexão com o banco de dados
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css"/>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="calendario.css">
    <title>Calendário</title>
</head>
<body>

    <div class="sidemenu">
        <p><a href="indexLogin.php">Página Inicial</a></p>
        <p><a href="addMovies.php">Adicionar Filme/Série</a></p>
        <p><a href="calendario.php">Lançamentos</a></p>
        <p><a href="profile.php">Meu Perfil</a></p>
    </div>

    <div id="calendar-container" class="calendario">
        <div id="calendar"></div>
    </div>


    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                editable: true,
                events: <?php echo json_encode($events); ?>,
                eventClick: function(event) {
                    alert('Informações do Filme/Série: ' + event.description);
                }
            });
        });
    </script>
    
</body>
</html>
