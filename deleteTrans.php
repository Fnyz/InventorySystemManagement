<?php


require_once "./Model/Saless.php";
$sales = new Saless();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sales->id = $_POST['id'];
    $sales->deleteData();
}
