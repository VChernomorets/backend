<?php

date_default_timezone_set('GMT');

// Status Codes and Their Messages
// Contains the path to the account file
$config = [
    'statuses' => [
        '400' => 'Bad Request',
        '404' => 'Not Found',
        '500' => 'Server Error',
        '200' => 'OK'
    ],
    'accountFile' => 'password.txt'
];


// не обращайте на эту функцию внимания
// она нужна для того чтобы правильно считать входные данные
function readHttpLikeInput()
{
    $f = fopen('php://stdin', 'r');
    $store = "";
    $toread = 0;
    while ($line = fgets($f)) {
        $store .= preg_replace("/\r/", "", $line);
        if (preg_match('/Content-Length: (\d+)/', $line, $m))
            $toread = $m[1] * 1;
        if ($line == "\r\n")
            break;
    }
    if ($toread > 0)
        $store .= fread($f, $toread);
    return $store;
}

$contents = readHttpLikeInput();

/**
 * Based on the input, generates a response from the server
 * @param $statusCode string Server response code
 * @param $statusMessage string Message describing the status code
 * @param $headers array Array with headers
 * @param $body string Server response body
 */
function outputHttpResponse($statusCode, $statusMessage, $headers, $body)
{
    echo implode(PHP_EOL, [
        "HTTP/1.1 {$statusCode} {$statusMessage}",
        "Date: {$headers['date']}",
        'Server: Apache/2.2.14 (Win32)',
        'Connection: Closed',
        'Content-Type: text/html; charset=utf-8',
        "Content-Length: {$headers['contentLength']}",
        '',
        $body
    ]);
}

/** We are processing the request.
 * We return the sum of the values ​​in the nums variable.
 * If the request link does not match, return 404.
 * If the method is not GET or the variable we need is not received, return 400.
 * @param $method string Data transfer method
 * @param $uri string Link
 * @param $headers array request headers
 * @param $body string Request body
 */
function processHttpRequest($method, $uri, $headers, $body)
{
    global $config;
    $uri = parseUri($uri);

    $body = preg_split('/&/', $body);
    $params = parseParams($body);
    $code = checkRequest($method, $uri, $headers, $params);
    if ($code === '200') {
        $body = authorization($params);
    } else {
        $body = $config['statuses'][$code];
    }

    $headers = [
        'date' => date('D, j M Y H:i:s e'),
        'contentLength' => strlen($body),
    ];

    outputHttpResponse($code, $config['statuses'][$code], $headers, $body);
}

/**
 * Splits an array with strings into an associative array
 * @param $body array Array with strings
 * @param string $pattern array splitting pattern
 * @return array Associative array with parameters
 */
function parseParams($body, $pattern = '/=/')
{
    $params = [];
    foreach ($body as $element) {
        $element = preg_split($pattern, $element);
        $params[$element[0]] = $element[1];
    }
    return $params;
}

/**
 * Searches for an account in the database.
 * Checks the data, and returns the result of the check
 * @param $params array Parameters that have a username and password
 * @return string User authorization check result
 */
function authorization($params)
{
    $account = getPassword($params['login']);
    if ($account === null) {
        return '<h1 style="color:red">Account not found</h1>';
    } else if ($account === $params['password']) {
        return '<h1 style="color:green">FOUND</h1>';
    } else {
        return '<h1 style="color:red">Wrong password</h1>';
    }
}

/**
 * We read the file, look for the account by login, and return the password from it.
 * If the account does not exist, return null.
 * @param $login string Account login
 * @return mixed|null Password - if an account is found. Null - if the account is not found
 */
function getPassword($login)
{
    global $config;
    $accounts = parseParams(preg_split('/\\n/', file_get_contents($config['accountFile'])), '/:/');
    return $accounts[$login] ?? null;
}

/**
 * We break uri into pieces. Separately write variables, separate path
 * @param $uri string A sequence of characters identifying an abstract or physical resource
 * @return array Disassembled into parts uri
 */
function parseUri($uri)
{
    $uri = preg_split("/\\?/", $uri);
    $link = $uri[0];
    $params = parseParams(preg_split("/&/", $uri[1]));
    return [
        'link' => $link,
        'params' => $params
    ];
}

/**
 * Check the correctness of the request.
 * If the request link does not match, return 404.
 * If the method is not GET or the variable we need is not received, return 400.
 * @param $method string Data transfer method
 * @param $uri array Parsed uri request
 * @param $headers array request headers
 * @return string If there are errors, then the error code. If there are no errors, then 200
 */
function checkRequest($method, $uri, $headers, $params)
{
    if ($method !== 'POST'
        || ($headers['Content-Type'] ?? '') !== 'application/x-www-form-urlencoded'
        || !isset($params['login'])
        || !isset($params['password'])) {
        return '400';
    }
    if (($uri['link'] ?? '') !== '/api/checkLoginAndPassword') {
        return '404';
    }
    global $config;
    if (!file_exists($config['accountFile'])) {
        return '500';
    }
    return '200';
}

/**
 * Parse http request.
 * We break it into pieces, and return the desired values.
 * @param $string string http request.
 * @return array unassembled http request.
 */
function parseTcpStringAsHttpRequest($string)
{
    $params = preg_split('/\\n/', $string);
    $top = preg_split('/\\s/', array_shift($params));
    $method = $top[0];
    $uri = $top[1];
    $headers = [];
    while (($header = array_shift($params)) !== '') {
        $element = preg_split('/:/', $header);
        $headers[$element[0]] = trim($element[1]);
    }
    $body = $params[0];
    return array(
        "method" => $method,
        "uri" => $uri,
        "headers" => $headers,
        "body" => $body,
    );
}

$http = parseTcpStringAsHttpRequest($contents);
processHttpRequest($http["method"], $http["uri"], $http["headers"], $http["body"]);

