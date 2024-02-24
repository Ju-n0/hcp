<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

use PHPMailer\PHPMailer\PHPMailer;

$method = strtolower($_SERVER['REQUEST_METHOD']);

if ($method !== 'post') {
    header('Location: /');
    die;
}

function getFormData($key)
{
    return $_POST[$key] ?? null;
}

function assertLettersOnly($key, $value, &$errors, $message)
{
    $notALetterRegex = '/[_!:§\/.;?,*µù%$£¨&"\'\(\[{#~|`\\^@à\]\)}=\d]+/';
    $matches         = [];

    preg_match($notALetterRegex, $value, $matches);

    if (!empty($matches)) {
        $errors[$key] = $message;
    }
}

function assertPhoneNumer($key, $value, &$errors, $message)
{
    $regex   = '/^\+?\d+$/';
    $matches = [];

    preg_match($regex, $value, $matches);

    if (empty($matches)) {
        $errors[$key] = $message;
    }
}

function assertEmail($key, $value, &$errors, $message)
{
    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
        $errors[$key] = $message;
    }
}

function formatMessage(
    $firstName,
    $lastName,
    $phoneNumber,
    $email,
    $message,
    $isHtml = true
) {
    if ($isHtml) {
        $html = "<p><strong>Prénom:</strong> {$firstName}</p>
                <p><strong>Nom:</strong> {$lastName}</p>
                <p><strong>Téléphone portable:</strong> {$phoneNumber}</p>";

        if (empty($email)) {
            $html .= "<p><strong>Email:</strong> non renseigné</p>";
        } else {
            $html .= "<p><strong>Email:</strong> {$email}</p>";
        }

        $html .= "<p><strong>Message:</strong></p>
                <p>{$message}</p>";

        return $html;
    }

    $text = "Prénom: {$firstName}\n
            Nom: {$lastName}\n
            Téléphone portable: {$phoneNumber}\n";

    if (empty($email)) {
        $text .= "Email: non renseigné\n";
    } else {
        $text .= "Email: {$email}\n";
    }

    $text .= "Message:\n{$message}";

    return $text;

}

$firstName   = getFormData('firstName');
$lastName    = getFormData('lastName');
$phoneNumber = getFormData('phoneNumber');
$email       = getFormData('email');
$message     = getFormData('message');

$errors = [];

$mandatoryFields = ['firstName', 'lastName', 'phoneNumber', 'message'];

foreach ($mandatoryFields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
        $errors[$field] = 'Veuillez renseigner ce champs.';
    }
}

$firstName   = trim($firstName);
$lastName    = trim($lastName);
$phoneNumber = trim($phoneNumber);
$message     = trim($message);

if (!empty($firstName)) {
    assertLettersOnly("firstName", $firstName, $errors, "Le prénom ne doit contenir que des lettres.");
}

if (!empty($lastName)) {
    assertLettersOnly("lastName", $lastName, $errors, "Le nom ne doit contenir que des lettres.");
}

if (!empty($phoneNumber)) {
    assertPhoneNumer('phoneNumber', $phoneNumber, $errors, "Ce numéro de portable n'est pas valide.");
}

if (!empty($email)) {
    $email = trim($email);
    assertEmail('email', $email, $errors, "L'email n'est pas valide.");
}

$response = [];

header('Content-Type: application/json');

if (empty($errors)) {
    $firstName   = htmlentities($firstName);
    $lastName    = htmlentities($lastName);
    $phoneNumber = htmlentities($phoneNumber);
    $message     = htmlentities($message);

    try {
        // envoi du mail
        $mail = new PHPMailer(true);
        //Server settings
        // $mail->isSendmail();

        // this is temporary and will be replaced by sendmail
        $mail->isSMTP();
        $mail->Host       = $config['mail']['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $config['mail']['username'];
        $mail->Password   = $config['mail']['password'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = $config['mail']['port'];

        $data = [
            'firstName'   => $firstName,
            'lastName'    => $lastName,
            'phoneNumber' => $phoneNumber,
            'message'     => $message
        ];

        if (!empty($email)) {
            $data['email'] = $email;
        }

        //Recipients
        if ($email) {
            $mail->setFrom($email, "{$data['firstName']} {$data['lastName']}");
        } else {
            $mail->setFrom("noreply@heritage-conseil-patrimoine.fr", "Email inconnu");
        }
        //Add a recipient
        $mail->addAddress($config['mail']['fake']['address'], $config['mail']['fake']['name']);

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = "Nouvel demande de contact";
        $mail->Body    = formatMessage($firstName, $lastName, $phoneNumber, $email, $message);
        $mail->AltBody = formatMessage($firstName, $lastName, $phoneNumber, $email, $message, false);

        $success = $mail->send();

        if (!$success) {
            throw new Exception();
        }

        //envoi réponse
        $response = [
            'status'  => 'success',
            'message' => 'Votre message a bien été envoyé.',
        ];

        echo json_encode($response);
    } catch (Exception $e) {
        $response = [
            'status'  => 'error',
            'message' => "Une erreur est survenue lors de l'envoi de votre message. Veuillez reessayer plus tard.",
        ];

        echo json_encode($response);
    }
} else {
    // envoi erreurs
    $response = [
        'status' => 'error',
        'errors' => $errors,
    ];

    http_response_code(400);
    echo json_encode($response);
}
