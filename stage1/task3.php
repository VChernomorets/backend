<?php

// не обращайте на эту функцию внимания
// она нужна для того чтобы правильно считать входные данные
function readHttpLikeInput() {
    $f = fopen( 'php://stdin', 'r' );
    $store = "";
    $toread = 0;
    while( $line = fgets( $f ) ) {
        $store .= preg_replace("/\r/", "", $line);
        if (preg_match('/Content-Length: (\d+)/',$line,$m))
            $toread=$m[1]*1;
        if ($line == "\r\n")
            break;
    }
    if ($toread > 0)
        $store .= fread($f, $toread);
    return $store;
}

$contents = readHttpLikeInput();

function outputHttpResponse($statuscode, $statusmessage, $headers, $body) {

    echo '';
}

function processHttpRequest($method, $uri, $headers, $body) {
    //if($method !== "GET" || )


    //outputHttpResponse();
}


/**
 * Parse http request.
 * We break it into pieces, and return the desired values.
 * @param $string string http request.
 * @return array unassembled http request.
 */
function parseTcpStringAsHttpRequest($string) {
    $params = preg_split('/\\n/', $string);
    $top = preg_split('/\\s/', array_shift($params));
    $method = $top[0];
    $uri = $top[1];

    $headers = [];
    while(($header = array_shift($params)) !== ''){
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

