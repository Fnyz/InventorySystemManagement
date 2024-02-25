<?php

require_once "./Model/Request.php";
$sales = new Request();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $r = $sales->showTrans();

    // Encode the data to JSON format
    $jsonResponse = json_encode($r);

    // Set the Content-Type header to application/json
    header('Content-Type: application/json');

    // Output the JSON response
    echo $jsonResponse;
}
?>
