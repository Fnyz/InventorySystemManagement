<?php

session_start();
require_once "./Model/Cust.php";
$cus = new Cust();




if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (isset($_POST['save'])) {


        $cus->fname = $_POST['cname'];
        $cus->lname = $_POST['lname'];
        $cus->phone = $_POST['phone'];
        $cus->id = $_POST['id'];

        var_dump($_POST);


        if ($cus->updateCus()) {
            $_SESSION['Saves'] = "Customer IS SUCCESSFULLY Updated!";
            header("Location: Supplier.php");
        };
    }
}
