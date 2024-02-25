<?php

session_start();
require_once "./Model/Cust.php";
$cus = new Cust();




if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (isset($_POST['save'])) {

        $cus->fname = $_POST['cname'];
        $cus->lname = $_POST['lname'];
        $cus->phone = $_POST['phone'];



        if ($cus->insertItem()) {
            $_SESSION['Saves'] = "PRODUCT IS SUCCESSFULLY ADDED!";
            header("Location: Supplier.php");
        };
    }
}
