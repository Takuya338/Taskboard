<?php

// INIファイルから設定を読み込む
$config = include('config.php');
$api_key = $config['openai_api_key'];

$endpoint = 'https://api.openai.com/v1/chat/completions';

$ch = curl_init($endpoint);

$headers = [
    'Authorization: Bearer ' . $api_key,
    'Content-Type: application/json',
    'Accept: application/json'
];

$data = [
    'model' => 'gpt-3.5-turbo',  // モデルを指定
    'messages' => [
        ['role' => 'system', 'content' => 'You are a helpful assistant.'],
        ['role' => 'user', 'content' => 'Translate the following English text to Japanese: "Hello, how are you?"']
    ]
];

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

if (!$response) {
    die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
}

$result = json_decode($response, true);
if (!isset($result['choices'][0]['message']['content'])) {
    die("Error: Invalid response from OpenAI API\n");
}

$completion = $result['choices'][0]['message']['content'];
echo $completion;

curl_close($ch);

?>
