<?php

session_start();
include_once "./Model/User.php";
$user = new User();




if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (isset($_POST['save'])) {


        $user->fname = $_POST['name'];
        $user->lname = $_POST['lname'];
        $user->username = $_POST['user'];
        $user->pass = $_POST['pass'];
        $user->id = $_POST['id'];




        if ($user->updateUser()) {
            $_SESSION['Saves'] = "Customer IS SUCCESSFULLY Updated!";
            header("Location: Accounts.php");
        };
    }
}
