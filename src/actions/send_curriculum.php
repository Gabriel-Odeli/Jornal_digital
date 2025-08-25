<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$nome = $_POST['nome'];
$email = $_POST['email'];
$curriculo = $_FILES['curriculo'] ?? null;
$email_empresa = $_POST['email_empresa'];
$body = file_get_contents("email.html");    
$body = str_replace("{{NOME}}", $nome, $body);
$body = str_replace("{{EMAIL}}", $email, $body);


$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['EMAIL_USER'];
    $mail->Password   = $_ENV['EMAIL_PASS'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('gabrielodeli8@gmail.com', 'ConectaNews');
    $mail->addAddress($email_empresa, 'Empresa');

    $mail->isHTML(true);
    $mail->Subject = 'Curriculo para emprego - ConectaNews';
    $mail->Body = $body;
    $mail->AltBody = "Você recebeu um novo currículo de $nome. Email: $email. O currículo está em anexo.";
    $mail->addEmbeddedImage('../imagens/ConectaNews.png', 'logo_cid');

    if ($curriculo && $curriculo['error'] === UPLOAD_ERR_OK) {
        $mail->addAttachment($curriculo['tmp_name'], $curriculo['name']);
    } else {
        header("Location: /sua_pagina.php?erro=notsend");
        exit;
    }

    $mail->send();
    header("Location: ../tela_empregos/tela_empregos.php?sucesso=send");
} catch (Exception $e) {
    header("Location: ../tela_empregos/tela_empregos.php?erro=notsend");
}
