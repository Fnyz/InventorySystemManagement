<?php

session_start();
require_once "./Model/Prod.php";
$prod = new Prod();




if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   
    if (isset($_POST['save'])) {


        echo "<pre>";
        var_dump($_POST);
        echo "</pre>";

     
        $prod->id = $_POST['id'];
        $prod->prod = $_POST['prod'];
        $prod->price = $_POST['price'];
        $prod->quantity = $_POST['quan'];
        $prod->desc = $_POST['desc'];



        if ($prod->updateProds()) {
            $_SESSION['Saves'] = "PRODUCT IS SUCCESSFULLY Updated!";
            header("Location: Product.php");
        };
    }
}
