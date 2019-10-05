<?php

session_start();

$_SESSION['login_user'] = false;

// Set headers

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Get DB library
require realpath('./../lib/db.php');

// Instantiate output

$out = (object) array(
    'status' => 0,
    'response' => 'Wrong credentials.',
);

$database = new DB();
$db = $database->get_connection();

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id FROM api_users WHERE username=:username AND password=:password";

    $query = $db->prepare($sql);

    $parameters = array(
        ':username'=> $username,
        ':password'=> $password
    );

    $query->execute($parameters);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if( $result ) {
        $out->status = 1;
        $out->response = $result;

        $_SESSION['login_user'] = $username;
    }
} else {
    // Log user out

    // Unset all of the session variables.
    $_SESSION = array();

    // Delete session cookies.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destroy session itself
    session_destroy();

    $out->status = 1;
}



echo json_encode($out);