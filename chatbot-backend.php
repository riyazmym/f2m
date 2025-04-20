<?php
header('Content-Type: application/json');

$apiKey = "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"; // <--- paste your OpenAI API key here

$input = json_decode(file_get_contents("php://input"), true);
$userMessage = $input['message'];

$data = [
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "system", "content" => "You are a helpful assistant for Farm2Market, assisting users with login, registration, selling, and product-related questions."],
        ["role" => "user", "content" => $userMessage]
    ]
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer " . $apiKey
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

$responseData = json_decode($response, true);
echo json_encode($responseData['choices'][0]['message']['content']);
?>
