<?php

session_start();

// Set headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Bootstrap output object
$out = (object) array(
    'status' => 0,
    'response' => false
);

// Set limit for students per page
$limit = 5;

if( $_SESSION['login_user'] ) {

    // Get DB library
    require realpath('./../lib/db.php');

    $database = new DB();
    $db = $database->get_connection();

    $sql = "SELECT * FROM students";
    $query = $db->prepare($sql);
    $query->execute();

    $record_count = $query->rowCount();
    $total_pages = ceil( $record_count/$limit );

    // If get param `page` exists, set $page variable, if not
    // make $page variable be 1, as in, first page.
    $page = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;

    $starting_record = ( $page - 1 ) * $limit;

    // SQL to fetch students list
    $sl_sql = "SELECT s.id, s.username, s.full_name, cg.group_name FROM students s LEFT JOIN class_group cg ON cg.id = s.class_group_id ORDER BY id ASC LIMIT :starting_record, :glob_limit;";

    $sl_query = $db->prepare($sl_sql);

    $sl_query->bindParam(':starting_record', $starting_record, PDO::PARAM_INT);
    $sl_query->bindParam(':glob_limit', $limit, PDO::PARAM_INT);

    $sl_query->execute(); 
    $students_list = $sl_query->fetchAll(PDO::FETCH_ASSOC);

    $out->status = 1;
    $out->response = array(
        'students' => $students_list,
        'total_pages' => $total_pages
    );
}

echo json_encode( $out );