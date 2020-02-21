<?php
$action = $_GET['action'] ?? '';
$data = json_decode(file_get_contents('php://input'), true);
$app = dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;
include $app . 'Todo.php';
include $app . 'Accounts.php';

// Calls the function requested by the user
switch ($action) {
    case 'register' :
        register($data['login'] ?? '', $data['pass'] ?? '');
        break;
    case 'login' :
        login($data['login'] ?? '', $data['pass'] ?? '');
        break;
    case 'logout' :
        logout();
        break;
    case 'addItem' :
        addItem($data['text'] ?? '');
        break;
    case 'changeItem' :
        changeItem($data['id'] ?? '', $data['text'] ?? '', $data['checked'] ?? '');
        break;
    case 'deleteItem' :
        deleteItem($data['id'] ?? '');
        break;
    case 'getItems' :
        getItems();
        break;
    default :
        showError('Section field error');
}

/**
 * Returns a list of all records.
 */
function getItems(){
    $accounts = new Accounts();
    $accounts->checkAuth();
    $todo = new Todo();
    echo json_encode($todo->getItems());
}

/**
 * Removes todo by her id
 * @param $id int id todo to delete
 */
function deleteItem($id){
    $accounts = new Accounts();
    $accounts->checkAuth();
    if (!valid($id, '/^[0-9]+$/')) {
        showError('The id field must contain at least 1 number');
    }
    $todo = new Todo();
    $todo->delete($id);
    showOk();
}

/**
 * Checks the correctness of the parameters.
 * If successful, changes todo in the database
 * @param $id int Identifier
 * @param $text string Post text
 * @param $checked bool status
 */
function changeItem($id, $text, $checked)
{
    $accounts = new Accounts();
    $accounts->checkAuth();
    if (!valid($id, '/^[0-9]+$/')) {
        showError('The id field must contain at least 1 number');
    }
    if (!valid($text, '/.{3}/')) {
        showError('The text field must contain at least 3 characters');
    }
    settype($checked, 'bool');
    if( $checked === ''){
        showError('The checked field must contain true or false');
    }
    $todo = new Todo();
    $todo->change($id,$text,$checked);
    showOk();
}

/**
 * checks the parameters. If successful, adds a new todo
 * @param $text string Post text
 */
function addItem($text)
{
    $accounts = new Accounts();
    $accounts->checkAuth();
    if (!valid($text, '/.{3}/')) {
        showError('The text field must contain at least 3 characters');
    }
    $todo = new Todo();
    $todo->add($text);
    showOk();
}

/**
 * Logs out of user account
 */
function logout()
{
    $accounts = new Accounts();
    $accounts->logout();
    showOk();
}

/** checks the parameters. If successful, logs into account
 * @param $login string login from account
 * @param $pass string password from account
 */
function login($login, $pass)
{
    if (!valid($login, '/.{1}/')) {
        showError('Login field error');
    }
    if (!valid($pass, '/.{3}/')) {
        showError('Pass field error');
    }
    $accounts = new Accounts();
    if($accounts->login($login, $pass)){
        showOk();
    } else {
        showError('Incorrect login or password');
    }
}

/**
 * checks parameters, if successful creates a new account
 * @param $login string login from account
 * @param $pass string password from account
 */
function register($login, $pass)
{
    if (!valid($login, '/.{1}/')) {
        showError('Login field error');
    }
    if (!valid($pass, '/.{3}/')) {
        showError('Pass field error');
    }
    $accounts = new Accounts();
    if($accounts->register($login, $pass)){
        showOk();
    }
}

/**
 * Displays an error to the user.
 * @param $message string error text
 */
function showError($message)
{
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(['error' => $message]);
    exit();
}

/**
 * Checks fields for correctness
 * @param $text string Text to check
 * @param $pattern string pattern to check
 * @return bool result of checking
 */
function valid($text, $pattern)
{
    return preg_match($pattern, $text);
}

/**
 * displays a message to the user if successful
 */
function showOk(){
    echo json_encode(['ok'=>true]);
}