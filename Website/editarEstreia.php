<?php
session_start();

$conn=new mysqli("localhost","id21772530_pedro","Porto2323_","id21772530_dbmovie");

$id = $_POST['editId'];
$titulo = $_POST['editTitulo'];
$data = $_POST['editData'];
$descricao = $_POST['editDescricao'];

$stmt = $conn->prepare("UPDATE events SET title = ?, start_date = ?, description = ? WHERE id = ?");
$stmt->bind_param("sssi", $titulo, $data, $descricao, $id);

if($stmt->execute()){
    echo "<script>alert('Alteração efetuada com sucesso!'); window.location.href = 'adminIndex.php';</script>";
}else{
    echo "<script>alert('Ocorreu um erro ao efetuar as alterações, por favor tente mais tarde.'); window.location.href = 'adminIndex.php';</script>";
}

$stmt->close();

?>