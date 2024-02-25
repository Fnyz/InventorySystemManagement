<?php

session_start();
require_once "./Model/User.php";
$user = new User();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (isset($_POST['save'])) {

        $user->fname = $_POST['first'];
        $user->lname = $_POST['last'];
        $user->phone = $_POST['phone'];
        $user->username = $_POST['user'];
        $user->pass = $_POST['pass'];
        $user->userType = $_POST['userType'];


        if ($user->insertUser()) {
            $_SESSION['Saves'] = "PRODUCT IS SUCCESSFULLY ADDED!";
            header("Location: login.php");
        };
    }
}
