<?php
include 'Tester.php';
$tester = new Tester(1);
print_r($tester->getResult());



/*if( true == 'строка'){ // true
    echo '1';
}

if(false === 'строка'){ // false
    echo '2';
}
if(false === (bool) 'строка'){ // false
    echo '3';
}
if(false === (bool) '0'){ // true
    echo '4';
}
if(false === '0'){ // false
    echo '5';
}*/