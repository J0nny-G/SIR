<?php
$para = "pedro.moura@ipvc.pt";
$assunto = "Teste de e-mail";
$mensagem = "Este é um e-mail de teste enviado pelo XAMPP.";

// Ajuste as configurações do servidor SMTP conforme necessário
$headers = "De: remetente@example.com";

// Envia o e-mail
mail($para, $assunto, $mensagem, $headers);
?>
