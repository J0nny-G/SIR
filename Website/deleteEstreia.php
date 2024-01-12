<?php
session_start();

$conn = new mysqli("localhost","root","","movitime");

$id = $_POST['delete_event_id'];

$sql = "DELETE FROM events WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if($stmt->execute()){
    echo "<script>alert('Eliminação efetuada com sucesso!'); window.location.href = 'adminIndex.php';</script>";
}else{
    echo "<script>alert('Ocorreu um erro ao efetuar a eliminação, por favor tente mais tarde.'); window.location.href = 'adminIndex.php';</script>";
}

$stmt->close();
?>