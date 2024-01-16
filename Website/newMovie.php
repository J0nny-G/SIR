<?php
// Inicie a sessão se ainda não estiver iniciada
session_start();

// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Conexão com a base de dados
    $conn = new mysqli("localhost", "root", "", "movitime");

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Recupere os valores do formulário
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $ano = $_POST['ano'];
    $duracao = $_POST['duracao'];
    $sinopse = $_POST['sinopse'];
    $trail = $_POST['trail'];
    $anoAtual = date("Y");;

    // Verificações adicionais
    if ($duracao <= 0) {
        echo "<script>alert('Erro: A duração deve ser maior que zero.');window.location.href = 'addMovies.php';</script>";
        exit;
    }

    if ($ano < 1895 ) {
        echo "<script>alert('Erro: O ano deve ser maior ou igual a 1895.');window.location.href = 'addMovies.php';</script>";
        exit;
    }

    if ($ano > $anoAtual ) {
        echo "<script>alert('Erro: O ano deve ser menor ou igual a $anoAtual.');window.location.href = 'addMovies.php';</script>";
        exit;
    }

    // Manipule o arquivo de imagem (certifique-se de ter as devidas permissões na pasta)
    $imagem_nome = uniqid() . '_' . $_FILES['capaFilme']['name'];
    $imagem_temp = $_FILES['capaFilme']['tmp_name'];
    $pasta_destino = "uploads/";

    // Verifica se é uma imagem
    $allowed_image_types = array("image/jpeg", "image/png", "image/gif");
    if (!in_array($_FILES['capaFilme']['type'], $allowed_image_types)) {
        echo "<script>alert('Erro: Apenas imagens JPEG, PNG ou GIF são permitidas.');window.location.href = 'addMovies.php';</script>";
        exit;
    }

    // Move o arquivo para a pasta de destino
    move_uploaded_file($imagem_temp, $pasta_destino . $imagem_nome);

    $sql = "INSERT INTO movies (name, duration, releaseYear, description, imgMovie, trail) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("sissss", $titulo, $duracao, $ano, $sinopse, $imagem_nome, $trail);

    if ($stmt->execute()) {
        // Obtenha o ID do filme inserido
        $idMovie = $stmt->insert_id;

        $idCategory = $genero;
        $sql_moviecategory = "INSERT INTO moviecategory (idMovie, idCategory) VALUES (?, ?)";
        $stmt_moviecategory = $conn->prepare($sql_moviecategory);
        $stmt_moviecategory->bind_param("ii", $idMovie, $idCategory);

        if ($stmt_moviecategory->execute()) {
            echo "<script>alert('Filme/Série adicionado com sucesso! Está em estado de aprovação.'); window.location.href = 'addMovies.php';</script>";
        } else {
            echo "<script>alert('Erro ao adicionar filme/série: " . $stmt_moviecategory->error . "');window.location.href = 'addMovies.php';</script>";
        }

        // Feche a declaração preparada da tabela moviecategory
        $stmt_moviecategory->close();
    } else {
        echo "<script>alert('Erro ao adicionar filme/série: " . $stmt->error . "');window.location.href = 'addMovies.php';</script>";
    }

    // Feche a declaração preparada e a conexão com o banco de dados
    $stmt->close();
    $conn->close();
}
?>
