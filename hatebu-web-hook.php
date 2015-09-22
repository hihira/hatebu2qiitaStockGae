<?php
include './Secret.php';
define('URL_QIITA_API', 'https://qiita.com/api/v2/items/');

$url = parse_url($_POST['url']);
if (strpos($url['host'], 'qiita.com') === false) {
    error_log("not qiita.com");
    exit;
}

$itemId = explode('/', $url['path'])[3];
error_log('stocking item id: '.$itemId);

$url = URL_QIITA_API.$itemId.'/stock';
$qiitaAccessToken = Secret::getQiita();

if (function_exists('curl_init')) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_PUT => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => $url,
        CURLOPT_HTTPHEADER => [
            'Content-type: application/json',
            'Authorization: Bearer '.$qiitaAccessToken,
        ],
    ]);
    $response = curl_exec($ch);
    if ($response === false) {
        error_log('Qiita API response error: curl failed. '.curl_error($ch));
    }
} else {
    $context = [
      'http' => [
        'method' => 'PUT',
        'header' => 'Content-type: application/json'          ."\r\n".
                    'Authorization: Bearer '.$qiitaAccessToken."\r\n",
      ]
    ];
    $context = stream_context_create($context);
    $response = file_get_contents($url, false, $context);
    if ($response === false) {
        error_log('Qiita API response error');
        exit;
    }
}

error_log('Success qiita stock');
