<?php

$links = [
    'v1' => [
        'addItem' => 'http://localhost/api/v1/addItem.php',
        'changeItem' => 'http://localhost/api/v1/changeItem.php',
        'deleteItem' => 'http://localhost/api/v1/deleteItem.php',
        'getItems' => 'http://localhost/api/v1/getItems.php',
        'login' => 'http://localhost/api/v1/login.php',
        'logout' => 'http://localhost/api/v1/logout.php',
        'register' => 'http://localhost/api/v1/register.php'
    ]
];

//checkLogout($links['v1']['logout']);
checkGetItems($links['v1']['getItems']);
//checkLogin($links['v1']['login']);
//checkRegister($links['v1']['register']);

//checkGetItems($links['v1']['getItems']);

function checkAddItem(){
    var_dump();
}

function checkGetItems($link){
    query($link);
}

function checkLogin($link){
    $user = [
        'login' => 'Dima',
        'pass' => 'vasyaPass'
    ];
    query($link, json_encode($user));
}

function checkRegister($link){
    $user = [
        'login' => 'newTest',
        'pass' => 'testerPass'
    ];
    query($link, json_encode($user));
}

function checkLogout($link){
    query($link);
}

function query($link, $data = ''){
    $cookieFileName = 'cookie.txt';
    checkCookieFile($cookieFileName);
    $query = curl_init();
    curl_setopt($query, CURLOPT_URL, $link);
    if($data !== '') {
        curl_setopt($query, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);
        curl_setopt($query, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($query, CURLOPT_HEADER, true);
    curl_setopt($query, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($query, CURLOPT_COOKIEFILE, $cookieFileName);
    curl_setopt($query, CURLOPT_COOKIEJAR,  $cookieFileName);
    print_r(curl_exec($query));
    //var_dump(curl_getinfo($query));
    curl_close($query);

    //CURLOPT_FAILONERROR
}

function checkCookieFile($cookieFileName){
    if(!is_writable(__DIR__)){
        header('500 Internal Server Error');
        exit('no permissions to write to ' . $cookieFileName);
    }
}