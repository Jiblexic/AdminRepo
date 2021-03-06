<?php
    
// Start Session
session_start();
ini_set('display_errors', '1');

// CONFIG
$GLOBALS['configs'] = array(
    'mysql' => array(
        'host' => 'localhost',
        'username' => 'cherries',
        'password' => 'Hello123!',
        'db' => 'cherries'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' =>  604800
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    ),
);

// Autoload my classes as and when required
spl_autoload_register(function($class){
    require_once('classes/' . $class . '.php');
});

// Function List
require_once('functions/sanitize.php');

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name')))
{
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));
    
    if($hashCheck->count()){
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }
}