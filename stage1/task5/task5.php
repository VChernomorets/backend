<?php

date_default_timezone_set('GMT');

// Status Codes and Their Messages
// name of base folders
$config = [
    'statuses' => [
        '400' => 'Bad Request',
        '404' => 'Not Found',
        '500' => 'Server Error',
        '200' => 'OK'
    ],
    'baseFolders' => [
        'another',
        'student'
    ]
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

/** We process the request.
 * If the request is correct, return the page.
 * If the request is not correct, we return the error code, and the text to it.
 * @param $method string Data transfer method
 * @param $uri string Link
 * @param $headers array request headers
 * @param $body string Request body
 */
function processHttpRequest($method, $uri, $headers, $body)
{
    global $config;
    $uri = parseUri($uri);
    $code = checkRequest($method, $uri, $headers);
    if ($code === '200') {
        $baseFolders = preg_split('/\\./', $headers['Host']);
        $page = getPage($uri['link'], $baseFolders[0]);
        if ($page === null) {
            $code = 404;
            $body = $config['statuses'][$code];
        } else {
            $body = $page;
        }
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
 * If uri is "/" - return the page "index.php" Otherwise,
 * look for a file with a name equal to uri. If the file exists,
 * return its value; if it does not exist, return null
 * @param $link string The name of the requested file
 * @param $baseFolders string base folder name
 * @return string|null File content, or null
 */
function getPage($link, $baseFolders){
    $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR;
    if($link === '/'){
        return file_get_contents($dir . 'index.html');
    } elseif(file_exists($dir . $baseFolders . $link)){
        return file_get_contents($dir . $baseFolders . $link);
    }
    return null;
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
 * In case of an error, return the error code.
 * If there are no errors, return code 200
 * @param $method string Data transfer method
 * @param $uri array Parsed uri request
 * @param $headers array request headers
 * @return string If there are errors, then the error code. If there are no errors, then 200
 */
function checkRequest($method, $uri, $headers)
{
    global $config;
    if ($method !== 'GET' || !isset($headers['Host'])
    ) {
        return '400';
    }
    $baseFolders = preg_split('/\\./', $headers['Host']);
    if (!in_array($baseFolders[0], $config['baseFolders'])) {
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

