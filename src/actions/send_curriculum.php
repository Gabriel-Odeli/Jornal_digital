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
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['EMAIL_USER'];
    $mail->Password   = $_ENV['EMAIL_PASS'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('gabrielodeli8@gmail.com', 'Seu Nome');
    $mail->addAddress($email_empresa, 'Nome do Destinatário');

    $mail->isHTML(true);
    $mail->Subject = 'Curriculo para emprego - ConectaNews';
    $mail->Body = "
    <h1>Nova candidatura recebida</h1>
    <p>Uma nova candidatura foi enviada atraves do site.</p>
    
    <h3>Dados do candidato:</h3>
    <ul>
        <li><b>Nome:</b> {$nome}</li>
        <li><b>E-mail:</b> {$email}</li>
    </ul>

    <p>O curriculo do candidato esta anexado a este e-mail.</p>
    <br>
    <p style='font-size:12px;color:#555;'>Mensagem automatica - Nao responda este e-mail.</p>";
    $mail->AltBody = "Nova candidatura recebida.\n\nNome: {$nome}\nE-mail: {$email}\nO currículo está anexado a este e-mail.";
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
