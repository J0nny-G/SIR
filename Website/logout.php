<?php
session_start();
session_destroy(); // Termina a sessão
header("Location: index.html"); // Redireciona para a página inicial (substitua "index.php" pelo caminho desejado)
exit();
?>
