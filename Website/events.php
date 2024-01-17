<?php
session_start();

$conn = new mysqli("localhost","id21772530_pedro","Porto2323_","id21772530_dbmovie");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$titulo = $_POST['novoNome'];
$dataIntroduzida = $_POST['dataLancamento'];
$descricao = $_POST['descricao'];

$insert_query = "INSERT INTO events (title, start_date , description) VALUES (?, ?, ?)";
$insert_stmt = $conn->prepare($insert_query);
$insert_stmt->bind_param("sss", $titulo, $dataIntroduzida, $descricao);

if ($insert_stmt->execute()) {
    echo "<script>alert('Lançamento com sucesso!'); window.location.href = 'adminIndex.php';</script>";
} else {
    echo "<script>alert('Ocorreu um erro ao registrar sua conta, por favor tente mais tarde.'); window.location.href = 'adminIndex.php';</script>";
}

// Fechar a conexão com o banco de dados
$insert_stmt->close();


?>