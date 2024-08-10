<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_POST) {
    require_once "PHPMailer/Exception.php";
    require_once "PHPMailer/PHPMailer.php";
    require_once "PHPMailer/SMTP.php";

    $mail = new PHPMailer();
    $your_email = "felipelullio+automatizator@gmail.com";

    // Check if it's an Ajax request
    if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        $output = json_encode(array('type' => 'error', 'text' => 'Request must come from Ajax'));
        die($output);
    }

    // Define required fields
    $fields = [
        'userName' => FILTER_SANITIZE_STRING,
        // 'firstName' => FILTER_SANITIZE_STRING,
        // 'lastName' => FILTER_SANITIZE_STRING,
        // 'fatherName' => FILTER_SANITIZE_STRING,
        // 'quoteName' => FILTER_SANITIZE_STRING,
        // 'userAddress' => FILTER_SANITIZE_STRING,
        // 'course' => FILTER_SANITIZE_STRING,
        'userEmail' => FILTER_SANITIZE_EMAIL,
        'userPhone' => FILTER_SANITIZE_STRING,
        'userSubject' => FILTER_SANITIZE_STRING,
        // 'userCity' => FILTER_SANITIZE_STRING,
        // 'projectType' => FILTER_SANITIZE_STRING,
        // 'propertyId' => FILTER_SANITIZE_STRING,
        // 'propertyType' => FILTER_SANITIZE_STRING,
        // 'quoteBudget' => FILTER_SANITIZE_STRING,
        'userAutomationType' => FILTER_SANITIZE_STRING,
        // 'service' => FILTER_SANITIZE_STRING,
        // 'reservationDate' => FILTER_SANITIZE_STRING,
        // 'totalPeople' => FILTER_SANITIZE_NUMBER_INT,
        // 'reserveTime' => FILTER_SANITIZE_STRING,
        // 'userGender' => FILTER_SANITIZE_STRING,
        'userMessage' => FILTER_SANITIZE_STRING
    ];
    // Define optional fields (for example, 'userPhone' and 'userSubject' are optional)
    $optionalFields = [
        'userName',
        'userPhone',
        'userSubject',
        'userAutomationType',
        'userMessage'
    ];    

    // Validate and sanitize required fields
    foreach ($fields as $field => $filter) {
        if (isset($_POST[$field]) && !empty($_POST[$field])) {
            $data[$field] = filter_var($_POST[$field], $filter);
        } elseif (in_array($field, $optionalFields)) {
            // For optional fields, just sanitize if present, or set default value if not present
            $data[$field] = isset($_POST[$field]) ? filter_var($_POST[$field], $filter) : '';
        } else {
            // For required fields that are missing or empty
            if (!in_array($field, $optionalFields)) {
                $output = json_encode(array('type' => 'error', 'text' => 'Input field "' . $field . '" is required!'));
                die($output);
            }
        }
    }

    // Additional PHP validation
    // if (strlen($data['userName']) < 3) {
    //     $output = json_encode(array('type' => 'error', 'text' => 'Nome muito curto ou vazio!'));
    //     die($output);
    // }

    if (!filter_var($data['userEmail'], FILTER_VALIDATE_EMAIL)) {
        $output = json_encode(array('type' => 'error', 'text' => 'Por favor, insira um e-mail válido'));
        die($output);
    }

    // if (strlen($data['userMessage']) < 5) {
    //     $output = json_encode(array('type' => 'error', 'text' => 'Mensagem muito curta. Por favor, insira alguma mensagem!'));
    //     die($output);
    // }

    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'lulliofelipe@gmail.com';
    $mail->Password = 'ugouqhpppbnseqep'; // Mude para a senha correta ou use um app password
    $mail->SMTPSecure = 'ssl';
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use 'ssl' para SSL e 'tls' para TLS
    $mail->Port = 465; // Use 587 para TLS ou 465 para SSL

    // Recipients
    $mail->setFrom($data['userEmail'], $data['userName']);
    $mail->addAddress($your_email, 'Felipe Lullio');
    $mail->addReplyTo($your_email, 'Felipe Lullio');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Novo Contato do site!';
    $mail->Body = "<h4 style='text-align: center;padding: 25px 15px;background-color: #0c6c9e;color: #FFFFFF;font-size:16px;width:90%;border-radius: 10px;'>Olá! Você tem uma nova mensagem do formulário do site.</h4><br><br>";

    foreach ($fields as $field => $filter) {
        if (isset($data[$field])) {
            $label = ucwords(str_replace(['_', 'Id'], [' ', ' ID'], $field));
            $mail->Body .= "<strong>{$label}: </strong>" . $data[$field] . "<br>";
        }
    }

    $mail->Body .= '<br><strong>Obrigado,</strong><br>' . $data['userName'];
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    // Send email
    if (!$mail->send()) {
        $output = json_encode(array('type' => 'error', 'text' => 'E-mail não enviado! ERRO! Checar configurações PHP.'));
        die($output);
    } else {
        $output = json_encode(array('type' => 'message', 'text' => 'Oi ' . $data['userName'] . ' , Obrigado pela mensagem!.'));
        die($output);
    }
}
?>
