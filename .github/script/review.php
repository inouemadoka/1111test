<?php
$envPath = getenv('GITHUB_EVENT_PATH');

$envData = json_decode(file_get_contents($envPath), true);

if($envData){
    $prUrl = $envData['pull_request']['url'];
    $number = $envData ['number'];

    echo "PRのURL:" .$prUrl . PHP_EOL;
    echo "PRの番号" . $number. PHP_EOL;

}else{
    echo "データが取得できませんでした";
}

//キーの取得
$apiKey = getenv('Cloud_API_secret');
if(empty($apiKey)){
    echo "キーが取得できませんでした";
}


$header =[

    "x-api-key:" .$apiKey,
    "anthropic-version: 2023-06-01",
    "content-type: application/json"
];

$body = [
    "model"=> "claude-3-7-sonnet-20250219",
    "max_tokens" => 1024,
    "messages"=> [
        [
            "role" => "user", 
            "content" => "Hello, world"
        ]
    ]
];

$ch = curl_init('https://api.anthropic.com/v1/messages');//endpoint
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

$reponse = curl_exec($ch);
$httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$responseData =json_decode($response);

if($httpStatus === 200){
    echo "成功" . json_encode($responseData). PHP_EOL;
}else{
    echo"ステータス:" . $httpStatus . " : ". json_encode($responseData). PHP_EOL;
}