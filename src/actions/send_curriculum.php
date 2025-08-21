<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);
try {
    // Configuração do servidor SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Servidor SMTP (ex: Gmail)
    $mail->SMTPAuth   = true;
    $mail->Username   = 'gabrielodeli8@gmail.com'; // Seu email
    $mail->Password   = 'ewwx szzs rouh vmir';          // Senha ou App Password do Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Remetente e destinatário
    $mail->setFrom('gabrielodeli8@gmail.com', 'Seu Nome');
    $mail->addAddress('gabrielodeli8@gmail.com', 'Nome do Destinatário');

    // Conteúdo
    $mail->isHTML(true);
    $mail->Subject = 'Teste de envio com PHPMailer';
    $mail->Body    = '<h1>Olá!</h1><p>Esse email foi enviado via <b>PHPMailer</b>.</p>';
    $mail->AltBody = 'Esse é o corpo alternativo sem HTML.';

    $mail->send();
    echo '✅ Email enviado com sucesso!';
} catch (Exception $e) {
    echo "❌ Erro: {$mail->ErrorInfo}";
}
?>