<?php
$url = parse_url($_POST['url']);
if (strpos($url['host'], 'qiita.com') === false) {
    error_log("not qiita.com");
    exit;
}

$itemId = explode('/', $url['path'])[3];
error_log('stocking item id: '.$itemId);

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_PUT => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_URL => 'https://qiita.com/api/v2/items/'.$itemId.'/stock',
    CURLOPT_HTTPHEADER => [
        'Content-type: application/json',
        'Authorization: Bearer '.getenv('ACCESS_TOKEN_QIITA'),
    ],
]);
$response = curl_exec($ch);

if ($response !== false) {
    exit;
}

error_log('Curl error: '.curl_error($ch));
