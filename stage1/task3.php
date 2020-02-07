<?php

date_default_timezone_set('GMT');

// Status Codes and Their Messages
$statuses = [
    '400' => 'Bad Request',
    '404' => 'Not Found',
    '200' => 'OK'
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
        //"Date: {$headers['date']}", - The task displays the date, but not in the tests
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
    global $statuses;
    $uri = parseUri($uri);

    $code = checkRequest($method, $uri);
    if ($code === '200') {
        $body = array_sum(preg_split('/,/', $uri['params']['nums']));
    } else {
        $body = $statuses[$code];
    }

    $headers = [
        'date' => date('D, j M Y H:i:s e'),
        'contentLength' => strlen($body),
    ];

    outputHttpResponse($code, $statuses[$code], $headers, $body);
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
    $params = [];
    foreach (preg_split("/&/", $uri[1]) as $element) {
        $element = preg_split('/=/', $element);
        $params[$element[0]] = $element[1];
    }
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
 * @return string If there are errors, then the error code. If there are no errors, then 200
 */
function checkRequest($method, $uri)
{
    if ($method !== 'GET' || !isset($uri['params']['nums'])) {
        return '400';
    }
    if ($uri['link'] !== '/sum') {
        return '404';
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
        array_push($headers, [$element[0], trim($element[1])]);
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

