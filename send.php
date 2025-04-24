<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';


    // Input sanitization
    $data = filter_input_array(INPUT_POST, [
        'name' => FILTER_SANITIZE_STRING,
        'phone' => FILTER_SANITIZE_STRING,
        'email' => FILTER_VALIDATE_EMAIL,
        'message' => FILTER_SANITIZE_STRING,
    ]);

    // Validation
    if (empty($data['name']) || empty($data['phone']) || !$data['email']) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        exit;
    }

    // Send email
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'contact@webooo.tech';
        $mail->Password = 'ForClients@963';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('contact@webooo.tech', $data['name']);
        $mail->addAddress('INFO@ALGARAWIGROUP.SA');
        $mail->Subject = "رسالة جديدة من {$data['name']}";
        $mail->Body = "
        <p>Name: {$data['name']}</p>
        <p>Email: {$data['email']}</p>
        <p>Phone: {$data['phone']}</p>
        <p>Message: {$data['message']}</p>
        ";

        $mail->send();
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $mail->ErrorInfo]);
    }
    exit;
}
?>