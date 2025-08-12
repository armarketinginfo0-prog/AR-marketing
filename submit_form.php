<?php
// Display errors while testing (remove later)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Your Brevo API Key
$apiKey = "PASTE_YOUR_NEW_API_KEY_HERE";

// Your Brevo List ID
$listId = 3; // Change this to your actual list ID

// Get form data
$firstname = $_POST['FIRSTNAME'] ?? '';
$email     = $_POST['EMAIL'] ?? '';
$phone     = $_POST['SMS'] ?? '';
$message   = $_POST['MESSAGE'] ?? '';

// Prepare payload
$data = [
    "listIds" => [$listId],
    "updateEnabled" => true,
    "email" => $email,
    "attributes" => [
        "FIRSTNAME" => $firstname,
        "SMS" => $phone,
        "MESSAGE" => $message
    ]
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.brevo.com/v3/contacts");
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "accept: application/json",
    "api-key: $apiKey",
    "content-type: application/json"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

// Log for debugging
file_put_contents("form_submissions.log", date("Y-m-d H:i:s") . "\n" . print_r($data, true) . "\n$response\n\n", FILE_APPEND);

if ($error) {
    echo "Error: $error";
} else {
    header("Location: thank-you.html");
    exit;
}
?>
