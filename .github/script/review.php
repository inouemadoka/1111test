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