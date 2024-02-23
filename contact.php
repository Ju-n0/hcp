<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

use PHPMailer\PHPMailer\PHPMailer;

$method = strtolower($_SERVER['REQUEST_METHOD']);

if ($method !== 'post') {
    die("Method not allowed");
}

function getFormData($key)
{
    return $_POST[$key] ?? null;
}

function assertLettersOnly($key, $value, &$errors, $message)
{
    $notALetterRegex = '/[_!:§\/.;?,*µù%$£¨&"\'\(\[{#~|`\\^@à\]\)}=\d]+/';
    $matches = [];

    preg_match($notALetterRegex, $value, $matches);

    if (!empty($matches)) {
        $errors[$key] = $message;
    }
}

function assertPhoneNumer($key, $value, &$errors, $message)
{
    $regex = '/^\+?\d+$/';
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

$firstName = getFormData('firstName');
$lastName = getFormData('lastName');
$phoneNumber = getFormData('phoneNumber');
$email = getFormData('email');
$message = getFormData('message');

$errors = [];

$mandatoryFields = ['firstName', 'lastName', 'phoneNumber', 'message'];

foreach ($mandatoryFields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
        $errors[$field] = 'Veuillez renseigner ce champs.';
    }
}

$firstName = trim($firstName);
$lastName = trim($lastName);
$phoneNumber = trim($phoneNumber);
$message = trim($message);

if (!empty($email)) {
    $email = trim($email);
}

assertLettersOnly("firstName", $firstName, $errors, "Le prénom ne doit contenir que des lettres.");
assertLettersOnly("lastName", $lastName, $errors, "Le nom ne doit contenir que des lettres.");
assertPhoneNumer('phoneNumber', $phoneNumber, $errors, "Ce numéro de téléphone n'est pas valide.");
assertEmail('email', $email, $errors, "L'email n'est pas valide.");

$response = [];

if (empty($errors)) {
    $firstName = htmlentities($firstName);
    $lastName = htmlentities($lastName);
    $phoneNumber = htmlentities($phoneNumber);
    $message = htmlentities($message);

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
            'firstName' => $firstName,
            'lastName' => $lastName,
            'phoneNumber' => $phoneNumber,
            'message' => $message
        ];

        if (!empty($email)) {
            $data['email'] = $email;
        }

        //Recipients
        $mail->setFrom($_POST['email'], "{$data['firstName']} {$data['lastName']}");
        $mail->addAddress($config['mail']['fake']['address'], $config['mail']['fake']['name']); //Add a recipient

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = "Nouvel demande de contact";
        $mail->Body = $_POST['message'];
        $mail->AltBody = $_POST['message'];

        $success = $mail->send();

        //envoi réponse
        $response = [
            'status' => 'success',
            'message' => 'Votre message a bien été envoyé.',
        ];

        echo json_encode($response);
    } catch (Exception $e) {
        echo $e->getMessage();
        $response = [
            'status' => 'error',
            'message' => 'Une erreur est survenue. Veuillez reessayer.',
        ];

        echo json_encode($response);
    }
} else {
    // envoi erreurs
    $response = [
        'status' => 'error',
        'errors' => $errors,
    ];

    echo json_encode($response);
}
